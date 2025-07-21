@php
  $containerFooter = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex flex-column flex-md-row justify-content-between align-items-center py-4">

      <!-- Branding -->
      <div class="mb-3 mb-md-0 text-center text-md-start">
        <h5 class="mb-1">ChatBuilder</h5>
        <p class="mb-0 text-muted">Créez des chatbots intelligents, sans code.</p>
      </div>

      <!-- Useful links -->
      <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-3">
        <a href="#" class="footer-link">Fonctionnalités</a>
        <a href="#" class="footer-link">Tarifs</a>
        <a href="#" class="footer-link">Documentation</a>
        <a href="#" class="footer-link">Support</a>
      </div>
    </div>

    <hr class="my-3">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-muted">
      <div class="mb-2 mb-md-0 text-center text-md-start">
        © {{ now()->year }} ChatBuilder. Tous droits réservés.
      </div>
      <div class="text-center text-md-end">
        <a href="#" class="footer-link me-3">Conditions</a>
        <a href="#" class="footer-link">Confidentialité</a>
      </div>
    </div>
  </div>
</footer>
