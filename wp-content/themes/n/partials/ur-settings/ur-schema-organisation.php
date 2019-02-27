<?php
$data = array(
	'active' => get_option('ur-org-schema-active'),
	'logo' => get_option('ur-org-schema-logo'),
	'facebook' => get_option('ur-org-schema-facebook'),
	'linkedin' => get_option('ur-org-schema-linkedin'),
	'google-plus' => get_option('ur-org-schema-google-plus'),
	'pinterest' => get_option('ur-org-schema-pinterest'),
	'instagram' => get_option('ur-org-schema-instagram'),
	'twitter' => get_option('ur-org-schema-twitter'),
	'youtube' => get_option('ur-org-schema-youtube'),
	'address-locality' => get_option('ur-org-schema-address-locality'),
	'address-postcode' => get_option('ur-org-schema-address-postcode'),
	'address-street' => get_option('ur-org-schema-address-street'),
	'fax' => get_option('ur-org-schema-fax'),
	'phone' => get_option('ur-org-schema-phone')
);
?>
<div class="organisation-schema col-wrapper">
	<div class="card col--50">
		<form id="schema-setting" method="post" action="<?php echo admin_url( 'admin.php' ); ?>">
			<h2>Organisation Schema</h2>
			<input type="hidden" name="action" value="ur_update_organisation_schema" />

			<input id="ur_schema-active" type="checkbox" name="active" value="1"
				<?php echo ($data['active'] == '1' ? "checked=''" : ''); ?>/>
			<label for="active">Show organisation schema on website</label>

			<h4>General</h4>

			<div class="form-field form-required term-name-wrap">
				<label for="logo">Logo <sup>*</sup></label>
				<input name="logo" id="ur_schema-logo" type="text" value="<?php echo $data['logo']; ?>" required>
			</div>
			<span><?php echo site_url(); ?>/$LOGO_URL$</span>

			<h4>Social Media</h4>

			<div class="form-field form-required term-name-wrap">
				<label for="facebook">Facebook URL</label>
				<input name="facebook" id="ur_schema-facebook" type="text" value="<?php echo $data['facebook']; ?>">
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="instagram">Instagram URL</label>
				<input name="instagram" id="ur_schema-instagram" type="text" value="<?php echo $data['instagram']; ?>">
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="twitter">Twitter URL</label>
				<input name="twitter" id="ur_schema-twitter" type="text" value="<?php echo $data['twitter']; ?>">
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="linkedin">Linkedin URL</label>
				<input name="linkedin" id="ur_schema-linkedin" type="text" value="<?php echo $data['linkedin']; ?>">
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="google-plus">Google Plus URL</label>
				<input name="google-plus" id="ur_schema-google-plus" type="text" value="<?php echo $data['google-plus']; ?>">
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="youtube">Youtube URL</label>
				<input name="youtube" id="ur_schema-youtube" type="text" value="<?php echo $data['youtube']; ?>">
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="pinterest">Pinterest URL</label>
				<input name="pinterest" id="ur_schema-pinterest" type="text" value="<?php echo $data['pinterest']; ?>">
			</div>

			<h4>Address</h4>

			<div class="form-field form-required term-name-wrap">
				<label for="address-locality">Locality <sup>*</sup></label>
				<input name="address-locality" id="ur_schema-address-locality" type="text" value="<?php echo $data['address-locality']; ?>" required>
			</div>
			<span>eg. Newcastle, England</span>

			<div class="form-field form-required term-name-wrap">
				<label for="address-postcode">Post Code <sup>*</sup></label>
				<input name="address-postcode" id="ur_schema-address-postcode" type="text" value="<?php echo $data['address-postcode']; ?>" required>
			</div>

			<div class="form-field form-required term-name-wrap">
				<label for="address-street">Street <sup>*</sup></label>
				<input name="address-street" id="ur_schema-address-street" type="text" value="<?php echo $data['address-street']; ?>" required>
			</div>

			<h4>Contact Details</h4>

			<div class="form-field form-required term-name-wrap">
				<label for="phone">Phone Number</label>
				<input name="phone" id="ur_schema-phone" type="text" value="<?php echo $data['phone']; ?>">
			</div>

			<?php submit_button('Update Organisation Schema'); ?>
		</form>
	</div>

	<div class=" col--50">
		<pre class='schema-code'>

{
    "@context": "http://schema.org/",
    "@type": "Organization",
    "url": "<code><?php echo site_url(); ?></code>",
    "logo": "<?php echo site_url(); ?>/<code id="preview_logo"></code>",
    "sameAs" : [
        "<code id="preview_facebook"></code>", <code class="comments">//Facebook</code>
        "<code id="preview_instagram"></code>", <code class="comments">//Instagram</code>
        "<code id="preview_twitter"></code>", <code class="comments">//Twitter</code>
        "<code id="preview_linkedin"></code>", <code class="comments">//Linkedin</code>
        "<code id="preview_google_plus"></code>", <code class="comments">//Google Plus</code>
        "<code id="preview_youtube"></code>", <code class="comments">//Youtube</code>
        "<code id="preview_pinterest"></code>", <code class="comments">//Pinterest</code>
    ],
    "address": {
        "@type": "PostalAddress",
        "addressLocality": "<code id="preview_address_locality"></code>",
        "postalCode": "<code id="preview_address_postcode"></code>",
        "streetAddress": "<code id="preview_address_street"></code>"
    },
    "telephone": "<code id="preview_phone"></code>"
}
		</pre>
	</div>
</div>

<script>
    jQuery(document).ready(function ($) {
        update_schema_preview();
        $(':text').keypress(function(e) {
            update_schema_preview();
        });
        $(':text').keyup(function(e) {
            update_schema_preview();
        });
        $(':text').bind('paste', function(e) {
            update_schema_preview();
        });
        function update_schema_preview(){
            $('#preview_logo').html($('#ur_schema-logo').val());
            $('#preview_facebook').html($('#ur_schema-facebook').val());
            $('#preview_google_plus').html($('#ur_schema-google-plus').val());
            $('#preview_linkedin').html($('#ur_schema-linkedin').val());
            $('#preview_youtube').html($('#ur_schema-youtube').val());
            $('#preview_pinterest').html($('#ur_schema-pinterest').val());
            $('#preview_instagram').html($('#ur_schema-instagram').val());
            $('#preview_twitter').html($('#ur_schema-twitter').val());
            $('#preview_address_locality').html($('#ur_schema-address-locality').val());
            $('#preview_address_postcode').html($('#ur_schema-address-postcode').val());
            $('#preview_address_street').html($('#ur_schema-address-street').val());
            $('#preview_phone').html($('#ur_schema-phone').val());
        }
    });
</script>

