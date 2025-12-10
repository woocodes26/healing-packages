# WhatsApp Healing Trip Packages Booking

A WordPress plugin to create and display therapeutic/medical travel packages with quick booking via WhatsApp. It adds a custom post type for packages, a modern grid on the front end, and a button that opens WhatsApp with a pre-filled message containing package details.

## Key Features
- Custom post type **Healing Packages** with fields for hospital, procedure type, hotel category, additional services, duration, cities, and per-package WhatsApp number.
- Taxonomy **Healing Package Categories** to group packages (countries or medical specialties) and filter via shortcode.
- Settings page to control the default WhatsApp number, the booking message template (placeholders like `{package_name}`, `{hospital}`, `{procedure_type}`, `{hotel_category}`), and the button text.
- Shortcode `[healing_packages]` that renders a responsive grid (1–4 columns) with RTL support and subtle hover effects.
- WhatsApp booking button that opens WhatsApp web/app with an encoded pre-filled message for the selected package.
- Modular codebase with overridable templates and lightweight CSS/JS.

## Requirements
- WordPress 6.0 or newer.
- PHP 7.4 or newer.

## Installation
1. Copy the plugin folder into `wp-content/plugins/healing-packages/` on your site.
2. In the dashboard, go to **Plugins** and activate **WhatsApp Healing Trip Packages Booking**.
3. (Optional) Clear caches/OPcache if your server uses them.

## Initial Setup
1. In the dashboard, open **Settings → Healing Packages** (or the settings page under the plugin menu).
2. Enter the default WhatsApp number in international format (e.g., `+201234567890`).
3. Edit the booking message and use placeholders:
   - `{package_name}`
   - `{hospital}`
   - `{procedure_type}`
   - `{hotel_category}`
4. Change the button text if needed (e.g., “Book via WhatsApp”).
5. Save changes.

## Create a Package
1. Go to **Healing Packages → Add New**.
2. Enter the package title (e.g., "11-Day Kerala Healing Trip").
3. Fill in the meta fields: hospital name, procedure type, hotel category, short description, additional services (list), duration and cities (optional), and a custom WhatsApp number if desired.
4. Choose relevant categories (country or specialty) to enable shortcode filtering.
5. Publish.

## Use the Shortcode
Add the shortcode to any page or post:

```shortcode
[healing_packages]
```

### Available Attributes
- `columns`: number of columns on desktop (default 3). Example: `[healing_packages columns="4"]`
- `category`: show packages in a taxonomy term (slug). Example: `[healing_packages category="india" columns="2"]`
- `ids`: show specific package IDs. Example: `[healing_packages ids="12,15,27" columns="3"]`

> The grid is responsive by default: 1 column on mobile, 2 on tablet, and 3–4 on desktop depending on attributes.

## Customization
- **Templates:** Adjust the card markup in `templates/package-card.php` or add hooks/filters.
- **Styles:** Core CSS lives in `assets/css/frontend.css` with neutral colors, a green WhatsApp button, and RTL tweaks. Override it in your theme if preferred.
- **Message:** The WhatsApp message is built from settings and package meta, URL-encoded for both web and app.

## Security & Performance
- All fields are sanitized/escaped with nonces on meta boxes and settings.
- CSS/JS enqueue only when the shortcode is present to reduce footprint.
- Capability checks are enforced (`manage_options` for settings, CPT edit caps for packages).
