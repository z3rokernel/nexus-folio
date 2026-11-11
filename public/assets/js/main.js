/**
 * NEXUS-FOLIO — Main Entry Point (Phase 0 Bootstrap)
 */
document.addEventListener('DOMContentLoaded', () => {
  const preloader = document.getElementById('nexus-preloader');
  if (preloader) {
    preloader.style.opacity = '0';
    preloader.style.display = 'none';
  }
  if (window.lucide) {
    window.lucide.createIcons();
  }
});
