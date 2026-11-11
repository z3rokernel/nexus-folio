<?php

namespace App\Controllers;

use App\Models\MessageModel;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    public function index(): string
    {
        $data = $this->withSiteContext([
            'namespace' => 'contact',
            'meta'      => [
                'title'       => 'INITIATE TRANSMISSION // Contact — NEXUS-FOLIO',
                'description' => 'Start a project or technical collaboration with Mostepha Amine BDEIR.',
                'canonical'   => base_url('contact'),
                'og_type'     => 'website',
            ],
        ]);

        return view('pages/contact', $data);
    }

    public function send(): ResponseInterface
    {
        $wantsJson = str_contains($this->request->getHeaderLine('Accept'), 'application/json')
            || $this->request->isAJAX();

        // Explicit controller-level honeypot check in addition to CI4 Honeypot filter
        $honeypotValue = $this->request->getPost('honeypot') ?? $this->request->getPost('website_url');
        if (! empty($honeypotValue)) {
            if ($wantsJson) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => 'error',
                    'message' => 'Automated transmission rejected.',
                ]);
            }

            return redirect()->back()->with('error', 'Automated transmission rejected.');
        }

        $rules = [
            'name'    => 'required|min_length[2]|max_length[140]',
            'email'   => 'required|valid_email|max_length[180]',
            'message' => 'required|min_length[20]|max_length[5000]',
        ];

        $messages = [
            'name' => [
                'required'   => 'IDENTIFICATION REQUIRED // Please enter your name.',
                'min_length' => 'Name must be at least 2 characters.',
            ],
            'email' => [
                'required'    => 'RETURN FREQUENCY REQUIRED // Please provide an email address.',
                'valid_email' => 'Invalid email coordinate format.',
            ],
            'message' => [
                'required'   => 'PAYLOAD EMPTY // Please describe your project or inquiry.',
                'min_length' => 'Transmission payload must be at least 20 characters.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            $errors = $this->validator->getErrors();
            if ($wantsJson) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON([
                        'status'    => 'error',
                        'message'   => 'VALIDATION FAILED // Please check highlighted fields.',
                        'errors'    => $errors,
                        'csrfHash'  => csrf_hash(),
                    ]);
            }

            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $payload = [
            'name'       => trim((string) $this->request->getPost('name')),
            'email'      => trim((string) $this->request->getPost('email')),
            'message'    => trim((string) $this->request->getPost('message')),
            'ip'         => $this->request->getIPAddress() ?: '127.0.0.1',
            'user_agent' => substr((string) $this->request->getUserAgent(), 0, 250),
        ];

        $messageModel = new MessageModel();
        $messageId    = $messageModel->insert($payload);

        // Attempt email dispatch if SMTP host is configured; gracefully log otherwise
        $smtpHost = env('email.SMTPHost', '');
        if (! empty($smtpHost)) {
            try {
                $emailService = \Config\Services::email();
                $emailService->setFrom(
                    (string) env('email.fromEmail', 'noreply@nexus-folio.dev'),
                    (string) env('email.fromName', 'NEXUS-FOLIO Transmission')
                );
                $emailService->setTo((string) env('CONTACT_TO', 'contact@nexus-folio.dev'));
                $emailService->setReplyTo($payload['email'], $payload['name']);
                $emailService->setSubject('[NEXUS-FOLIO] New Transmission from ' . $payload['name']);
                $emailService->setMessage(
                    "Sender: {$payload['name']} <{$payload['email']}>\n" .
                    "IP: {$payload['ip']}\n\n" .
                    "Message:\n{$payload['message']}\n"
                );
                @$emailService->send();
            } catch (\Throwable $e) {
                log_message('warning', 'Contact email dispatch skipped: ' . $e->getMessage());
            }
        }

        if ($wantsJson) {
            return $this->response
                ->setStatusCode(200)
                ->setJSON([
                    'status'        => 'success',
                    'transmission'  => 'TX-' . str_pad((string) $messageId, 5, '0', STR_PAD_LEFT),
                    'message'       => 'TRANSMISSION SENT // Signal locked. Expect response within 24h.',
                    'csrfHash'      => csrf_hash(),
                ]);
        }

        return redirect()->to(route_to('contact'))
            ->with('success', 'TRANSMISSION SENT // Signal locked. Expect response within 24h.');
    }
}
