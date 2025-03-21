<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package cb-shfuk2024
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

?>
<footer>
    <div class="container-xl pt-5">
        <div class="row g-4 justify-content-center pb-5">
            <div class="col-sm-6 col-md-3 text-center">
                <img class="footer__logo mb-4" width=300 height=94 src="<?=get_stylesheet_directory_uri()?>/img/shf-logo--light.svg" alt="">
                <div class="mb-4">Call us today on<br><strong><?=do_shortcode('[contact_phone]')?></strong></div>
                <?=social_icons()?>
                <div class="pt-4">
                  <!-- TrustBox script -->
                  <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
                  <!-- End TrustBox script -->
                  <!-- TrustBox widget - Micro Star -->
                  <div class="trustpilot-widget" data-locale="en-GB" data-template-id="5419b732fbfb950b10de65e5" data-businessunit-id="5458ad5900006400057b543a" data-style-height="25px" data-style-width="100%" data-theme="dark">
                      <a href="https://uk.trustpilot.com/review/sellhousefast.co.uk" target="_blank" rel="noopener">Trustpilot</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl colophon pb-4">
        <div class="row g-4">
            <div class="col-md-6 order-2 order-md-1">
                &copy; <?=date('Y')?> SellHouseFast | Sell House Fast is a trading style of Jolack Limited Registered in England, no. 15683659.<br>
                Registered address: Office 1.01, 411 - 413 Oxford Street, London, England, W1C 2PE
            </div>
            <div class="col-md-6 order-1 order-md-2 d-flex align-items-center justify-content-md-end flex-wrap gap-1">
                <a href="/sitemap/">Sitemap</a> |
                <a href="/privacy-policy/">Privacy</a> &amp; <a href="/cookie-policy/">Cookie</a> Policy</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@ideal-postcodes/address-finder-bundled@4"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Select all postcode fields
    var postcodeFields = document.querySelectorAll('input[type="text"][id^="postcode_"]'); 

    // Initialize Address Finder for each postcode field
    postcodeFields.forEach(function (field) {
      // Initialize Address Finder for each postcode field
      IdealPostcodes.AddressFinder.setup({
        apiKey: "ak_m0v8lgbiVjp4GmNgoHssE4wAxCqmq",
        inputField: field,  // Bind to the specific postcode field
        outputFields: {
          line_1: "#addr1",
          line_2: "#addr2",
          line_3: "#addr3",
          post_town: "#town",
          postcode: "#" + field.id
        },

        // Log when address is retrieved (for debugging)
        onAddressRetrieved: function (address) {
          console.log("Address Retrieved for:", field.id, address);

          // Manually assign the address data to the fields
          document.getElementById('addr1').value = address.line_1 || '';
          document.getElementById('addr2').value = address.line_2 || '';
          document.getElementById('addr3').value = address.line_3 || '';
          document.getElementById('town').value = address.post_town || '';
          
          // Also, you can manually set the postcode in the field if needed
          field.value = address.postcode;

          // Once the address is retrieved, you can process the data
          var line1 = document.getElementById('addr1').value;
          var line2 = document.getElementById('addr2').value;
          var line3 = document.getElementById('addr3').value;
          var postTown = document.getElementById('town').value;
          var postcodeOutput = field.value;

          // If line1 has a value, auto-submit by redirecting
          if (line1) {
            var formPageUrl = "/free-cash-offer-form/?" + new URLSearchParams({
              addr1: line1,
              addr2: line2,
              addr3: line3,
              town: postTown,
              postcode: postcodeOutput
            }).toString();

            console.log("Auto-submitting and redirecting to: ", formPageUrl);
            window.location.href = formPageUrl;
          }
          else {
            console.log('no line1');
          }
        },
        onAddressSelected: function (address) {
          // This function is called when an address is selected
          console.log("Address selected:", address);
        },
        // Log any errors during search (for debugging)
        onSearchError: function (error) {
          console.error("Search Error for:", field.id, error);
        }
      });
    });

    // Handle button click to redirect to the form page
    var buttons = document.querySelectorAll('.formbutton');  // Assume the button has class 'button-sm'
    
    buttons.forEach(function (button) {
      button.addEventListener('click', function (e) {
        e.preventDefault();

        var postcodeField = document.querySelector('input[type="text"][id^="postcode_"]');
        var line1 = document.getElementById('addr1').value;
        var line2 = document.getElementById('addr2').value;
        var line3 = document.getElementById('addr3').value;
        var postTown = document.getElementById('town').value;
        var postcodeOutput = postcodeField ? postcodeField.value : '';

        // If postcode is empty, redirect to /free-cash-offer-form/
        if (!line1) {
          console.log('no address selected');
          window.location.href = "/free-cash-offer/";
          return;
        }

        // Build the URL with query parameters to pass the address data
        var formPageUrl = "/free-cash-offer-form/?" + new URLSearchParams({
          addr1: line1,
          addr2: line2,
          addr3: line3,
          town: postTown,
          postcode: postcodeOutput
        }).toString();

        // Redirect to the form page
        // Log the URL to console for you to see the output
        console.log("Redirecting to: ", formPageUrl);
        window.location.href = formPageUrl;

      });
    });

  });
</script>

<!-- Add Hidden Fields -->
<input type="hidden" id="addr1" name="addr1">
<input type="hidden" id="addr2" name="addr2">
<input type="hidden" id="addr3" name="addr3">
<input type="hidden" id="town" name="town">
<input type="hidden" id="postcode_output" name="postcode_output">

<?php wp_footer(); ?>
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js-eu1.hs-scripts.com/145136229.js"></script>
<!-- End of HubSpot Embed Code -->
</body>
</html>