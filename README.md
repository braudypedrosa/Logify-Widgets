# Lodgify Calendar Widgets

Display real-time availability calendars and booking widgets for vacation rental properties using the Lodgify API.

## Features

- **Availability Calendar** - Display property availability with disabled dates for booked periods
- **Booking Widget** - Interactive booking form with date range selection and pricing
- **Lodgify API Integration** - Real-time synchronization with your Lodgify property data
- **Multiple Calendars** - Show multiple months at once for better visibility
- **Flexible Shortcodes** - Easy implementation with customizable attributes
- **Guest Management** - Set minimum stay requirements and guest counts

## Installation

1. Upload the plugin files to `/wp-content/plugins/Logify-Widgets`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to 'Lodgify Calendar' in the WordPress admin menu
4. Enter your Lodgify API key in the settings page

## Usage

**Display Availability Calendar:**

Use the shortcode with your property's listing ID:

```
[lodgify_calendar listingid="123456"]
```

**Display Booking Widget:**

Show an interactive booking form with pricing:

```
[lodgify_booking_widget listingid="123456" minstay="3"]
```

**Shortcode Parameters:**
- `listingid` - Your Lodgify property ID (required)
- `minstay` - Minimum number of nights for booking (optional, default: 1)

**Getting Your API Key:**
1. Log in to your Lodgify account
2. Navigate to Settings > API
3. Copy your API key
4. Paste it in the plugin settings page

## Requirements

- WordPress 5.0+
- PHP 7.2+
- Active Lodgify account with API access
- jQuery (included with WordPress)

