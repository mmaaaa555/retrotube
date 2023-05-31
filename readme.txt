== RetroTube ==

== Translations ==
Contribute to translations: https://github.com/wp-script/products-translations

== Changelog ==
= 1.7.2 = 2023-03-06
* Fixed: Fix html validation to prevent false positive for script tags that contain code
* Fixed: Fix UI issue in video description block on desktop

= 1.7.1 = 2023-02-28
* Fixed: Fix html validation to prevent false positive for html tags with hyphens in attribute names

= 1.7.0 = 2023-02-28
* Added: Add option with new thumbnails ratios (9/16 for mobile videos like short, tiktok, instagram, etc.)
* Added: New real time verification of html code for advertising and code blocks options (in admin panel)
* Added: New verification of html code you can have added in options to prevent any site break (on the site)
* Added: If an error is detected in any ad option code, the code is not displayed and an error message is displayed instead in the front end.
* Added: If an error is detected in any javascript or meta verification option code, the code is not inserted at all in the front end.
* Updated: Update theme options in advertising and code tabs for desktop
* Updated: Update theme options in advertising and code tabs for mobile
* Fixed: Fix Warning array_map() for PHP 8.x
* Fixed: Fix Carousel next and previous buttons position

= 1.6.9 = 2022-05-31
* Fixed: Fix main script versioning issue that could prevent new versions of the theme to work properly
* Fixed: Fix video.js initialisation issue that could prevent video tags in posts descriptions to work properly

= 1.6.8 = 2022-05-31
* Updated: Remove confusing default ads exemples in widgets

= 1.6.7 = 2022-05-13
* Updated: Update how videos are displayed on a video page, depending on their options. Videos are now displayed like the following
* Updated: Either all videos one after the other, if video or iframe tags are found in the video post description
* Updated: Either only one video from the Retrotube video informations box. The priority follows the same order as the video informations options appear in the video post edit page (video url > Resolutions > Video embed code > Video shortcode)
* Updated: This update prevents videos to be displayed twice with videos imported with the WPS Youtube Importer
* Updated: This update prevents videos to be displayed twice when multiple video informations options were filled
* Fixed: Fix videos thumbnails that were not showing in admin widget page
* Fixed: Fix issue that could prevent the integrated video player to work on some browsers

= 1.6.6 = 2022-04-28
* Updated: All videos found in a video post description are now displayed instead of only the first.
* Updated: All videos found in a video post (description + theme options) are now displayed instead of only one based on previous priority. This prevents to misunderstand how videos are displayed or not.
* Updated: Ads from the theme options are displayed over each video found.
* Updated: keeps compatibility with WPS-Player plugin.

= 1.6.5 = 2022-02-28
* Added: Add option with new thumbnails ratios (DVD + Square)
* Added: Add option to set the thumbnails fit (contain / cover / fill)
* Fixed: Fix thumbnail ratio on photos

= 1.6.4 = 2022-02-24
* Added: New option to set the number of blog posts per page in the blog section
* Fixed: Fix photos not displayed in photo archive page

= 1.6.3 = 2022-02-21
* Added: Add photos height and width in carousel for better speed and seo
* Added: Better theme css versioning for cache compatibility
* Fixed: Photos height in related photo galleries
* Fixed: Photos preview that could open under the photos thumbs
* Fixed: Visual bug on captions in galleries of photos
* Fixed: Meta social description when text is too long or has html tags
* Fixed: Theme options icon when child theme is activated
* Fixed: Visual bug on menu that could happen after switching theme
* Fixed: Fatal error when installing the theme before the core

= 1.6.2 = 2022-01-03
* Fixed: Removed an error log that could spam the php errors log file on the server

= 1.6.1 = 2022-01-03
* Added: Categories and tags list in single blog posts

= 1.6.0 = 2021-11-30
* Fixed: Embed pregmatch warning
* Fixed: Php fatal error when login to WordPress from softaculous

= 1.5.9 = 2021-08-18
* Fixed: Like and dislike buttons not working with LiveJasmin videos

= 1.5.8 = 2021-06-23
* Fixed: Breadcrumb php fatal error on attachment pages

= 1.5.7 = 2021-06-18
* Fixed: Carousel hidden images not loading issue
* Fixed: Carousel height issue on video previews
* Fixed: Carousel width issue on large screen with too few images

= 1.5.6 = 2021-06-15
* Fixed: Videos posts now use the_content() for better compatibility with Elementor and Divi
* Fixed: Lazyload that could prevent thumbnails to load correctly

= 1.5.5 = 2021-06-11
* Added: Theme support for responsive embeds
* Fixed: Breadcrumb php warning
* Fixed: Domain check for video replacement

= 1.5.4 = 2021-05-17
* Added: New niche "GAY" added to Niches section in the theme options
* Fixed: Division by zero error on thumbnails when theme options are not saved

= 1.5.3 = 2021-05-10
* Fixed: No compatible source was found for this media

= 1.5.2 = 2021-05-04
* Fixed: 16/9 ratio option that could prevent thumbnails to be visible
* Fixed: Iframe replacement in video post edition page issue when the domain name is likely to the iframe tube domain name

= 1.5.1 = 2021-03-15
* Fixed: Milf Niche import issue
* Fixed: Multiple levels sub-menu issue

= 1.5.0 = 2020-12-18
* Fixed: Read more visual bug on video pages
* Fixed: Description issues with html tags in social share data
* Fixed: Social media share buttons issues
* Fixed: Issue with the login/register modal not showing

= 1.4.9 = 2020-12-08
* Added: new option to import a json backup file in the Niches tab of the theme options (you can export your theme options in the Export tab of the theme options)
* Updated: Increase thumbs rotation speed from 300ms to 750ms
* Updated: Views/likes/dislikes are now displayed with human numbers (eg. 45K instead of 45325)
* Fixed: Like/dislikes ratio is now rounded to ceil instead of to floor

= 1.4.8 = 2020-12-01
* Fixed: Thumbnails that were not displayed when a featured image exists but is empty
* Fixed: Pagination display issue on multiple lines

= 1.4.7 = 2020-11-24
* Fixed: Remove nested ajax queries to set views and get post views and rating
* Fixed: No ajax action is performed when views and rating system options are disabled to avoid unnecessary calls to admin-ajax.php

= 1.4.6 = 2020-11-23
* Fixed: No more redirection to homepage on author pages for visitors that are not logged in

= 1.4.5 = 2020-10-22
* Updated: Bxslider v4.2.12 > v4.2.15
* Updated: Load Bxslider minified js for page load speed
* Fixed: Middle click on carousel
* Fixed: Images not visibile in the carousel

= 1.4.4 = 2020-10-22
* Fixed: Cannot read property clientHeight of undefined JS error

= 1.4.3 = 2020-10-21
* Added: Trailers and thumbs rotations now work on mobile and tablet with swipes (when they are available)
* Added: New option to edit Follow Us text in top bar
* Added: New option to add Reddit profile in the top bar
* Updated: Enhanced videos trailers and thumbs rotations management on desktop
* Updated: Enhanced lazyload on video images for page load speed
* Fixed: Trailers type detection that prevented them to be played
* Fixed: All theme options display issues on small devices
* Fixed: Users that log out on private pages are now redirected to the home page
* Fixed: Troncated site title on mobile when the title is too long
* Fixed: Actors lists links to each actor that prevented actors pages to be indexed correctly by search engines
* Fixed: Twitter share link

= 1.4.2 = 2020-08-11
* Updated: VideoJS from v7.4.1 to v7.8.4
* Updated: videojs-quality-selector 1.1.2 to 1.2.4
* Updated: VideoJS load exclusion when kenplayer is installed
* Updated: Auto enable WordPress registration option when Theme membership option is "on"
* Updated: Random relative videos in default template
* Updated: Add links to customize widget and mobile ads in options page
* Fixed: jQuery().live is not a function since WordPress 5.5
* Fixed: Theme activation warnings
* Fixed: Widgets not displayed when switching theme
* Fixed: Closing div issues in options page

= 1.4.1 = 2020-07-30
* Updated: Related videos are now from same category but randomized in videos widget block
* Fixed: Warning count() Parameter must be an array or an object that implements Countable warnings in some pages
* Fixed: Sticky posts are removed from queries in videos widget block

= 1.4.0 = 2020-06-05
* Added: Video file upload in the video form for members (.mp4)
* Added: Thumbnail file upload in the video form for members (.png, .gif, .jpg, .jpeg)
* Added: New video form options to display or not each field in the form
* Added: New video form options to make each field required or not
* Added: Prevent form to be displayed when using unconfigured reCaptcha
* Added: Full frontend (js) and backend (php) video form check for errors before submitting
* Added: File format and file size check on each uploaded file
* Updated: Member video form submission fully rewritten
* Fixed: Set the member as the author when a post is created from the video form (instead of the admin)
* Fixed: Reselect the selected category in the video form when an error occures
* Fixed: Video title set to 'Untitled' when Title field is empty on video form submission

= 1.3.9 = 2020-02-13
* Fixed: Footer logo displaying issue

= 1.3.8 = 2020-02-07
* Added: Limit to display up to 1000 tags on tags page to prevent memory issues
* Fixed: Missing field thumbnailUrl issue in Google indexing
* Fixed: Use gmdate() instead of date() to prevent durations issues on some servers configuration

= 1.3.7 = 2019-08-09
* Added: New niche "MILF" added to Niches section in the theme options
* Fixed: Extra double quote before "First" text in the pagination

= 1.3.6 = 2019-07-19
* Added: New niche "Hentai" added to Niches section in the theme options

= 1.3.5 = 2019-07-17
* Fixed: Warnings and errors with very old versions of PHP (but please, update your PHP version)
* Fixed: bxSlider JS error when activating the Caroussel feature without adding videos to it

= 1.3.4 = 2019-07-01
* Added: New niche "College" added to Niches section in the theme options

= 1.3.3 = 2019-06-26
* Added: New niche "Lesbian" added to Niches section in the theme options
* Added: Resolution switcher compatibility with FluidPlayer and WPS Player

= 1.3.2 = 2019-06-20
* Added: New niche "Trans" added to Niches section in the theme options

= 1.3.1 = 2019-06-17
* Added: New niche "LiveXCams" added to Niches section in the theme options

= 1.3.0 = 2019-06-14
* Added: New niche "FILF" added to Niches section in the theme options
* Added: New theme option section named "Niches" which allows you to change the look of your site in one click
* Added: New option named "Rendering" with 2 choices "Flat" or "Gradient"
* Fixed: Photo gallery on blog posts and pages displaying

= 1.2.9 = 2019-05-14
* Added: New option to choose the categories thumbnail quality
* Added: New option to display or not the sidebar on categories template page
* Added: New option to choose the number of categories per row
* Added: New option to choose the number of videos per category page
* Added: New option "background size" for the custom background section
* Fixed: Video-functions.php file to be child theme ready
* Fixed: A non-numerical value encountered warnings with php 7.3
* Fixed: Warning count() Parameter must be an array or an object that implements Countable" warnings with php 7.3

= 1.2.8 = 2019-04-29
* Fixed: Close ad button when no ad displaying issue
* Fixed: PHP "Fatal error Can't use function return value in write context" with some old PHP versions

= 1.2.7 = 2019-04-26
* Fixed: bxSlider click event issue on Chrome
* Fixed: Number of categories per page option
* Fixed: In-video banner display when WPS player plugin activated

= 1.2.6 = 2019-04-24
* Added: New layout option "Boxed" or "Full Width"
* Added: Option to display or not your logo in the footer
* Added: Alt tag in the footer logo image
* Added: New option to display Title and Description at the top or the bottom of the homepage
* Added: New option to display H1 title on the homepage to improve SEO
* Added: New option to display the tag description at the top or the bottom of the tag page
* Updated: Possibility to display photos and blog categories and tags directly from the menu items selector
* Updated: Login link in the comment section when users have to be logged to post a comment
* Fixed: Thumbnails rotation (the first image was bypass, the latest was displayed two times)
* Fixed: Actor name in the breadcrumb
* Fixed: Popular videos filter
* Fixed: Likes counter display that could go back to the line
* Fixed: Uncaught (in promise) DOMException console error when hovering videos trailers too fast in Google Chrome

= 1.2.5 = 2019-01-18
* Updated: New WordPress editor for Blog and Photos posts

= 1.2.4 = 2019-01-09
* Added: 4k resolution field in Video Information metabox
* Fixed: Menu button position on mobile device
* Fixed: Some banners displayed over the open mobile menu

= 1.2.3 = 2018-12-18
* Fixed: Actors taxonomy not showed in video post admin since WordPress 5 release

= 1.2.2 = 2018-12-05
* Added: Option in Membership section to display or not the admin bar for logged in users
* Added: Option in Mobile section (Code tab) to add scripts only for mobile device
* Added: New "Code" tab option in Mobile section
* Updated: get_stylesheet_directory_uri() function replaced by get_template_directory_uri() for child theme compatibility
* Fixed: Breadcrumbs displaying
* Fixed: Thumb link didn't work on mobile in some cases
* Fixed: Logo and menu position on mobile
* Fixed: Before play advertising displaying when embed code was added directly in the description field
* Fixed: Minor bugs

= 1.2.1 = 2018-11-15
* Updated: Menu section position on mobile device
* Updated: Top bar elements position on mobile device
* Fixed: Other images than gallery images, like banners for example, opened in lightbox in photos gallery pages
* Fixed: Fluid Player on pause ads that didn't work in JavaScript
* Fixed: Fluid Player on start ads that didn't close when playing the video
* Fixed: Fluid Player console error "Cannot read property 'setAttribute' of null"
* Fixed: Minor bugs

= 1.2.0 = 2018-11-06
* Added: Thumbnail image in RSS feed
* Fixed: JavaScript versioning

= 1.1.9 = 2018-11-02
* Fixed: In-video advertising location size in mobile version
* Fixed: YouTube embed player generation from YouTube video URL

= 1.1.8 = 2018-10-31
* Fixed: Close over video advertising issue with iframe players

= 1.1.7 = 2018-10-30
* Added: Mid-roll in-stream ad with timer in the "Video Player" theme option section. It plays a video advertising in the middle of the video automatically (you can set a timer when you want the advertising starts. For example 50%.)
* Added: Pre-roll in-stream ad in the "Video Player" theme option section. It plays a video advertising with a skip ad button at the beginning
* Added: Close and play button at the bottom of the banners over the video which automatically plays the video
* Added: On pause advertising zone 1 & 2 in the "Video Player" theme option section. These banners are displayed over the video player when the user pauses the video
* Added: Before play advertising zone 1 & 2 in the "Video Player" theme option section. These banners are displayed over the video player when the user arrives on the page
* Added: New logo options in the "Video Player" theme option section (with logo position, margin, opacity and grayscale features)
* Added: Playback Speed option in the "Video Player" theme option section (Add a new control bar option to allow users to play video at different speeds)
* Added: New Autoplay option in the "Video Player" theme option section (The video plays automatically)
* Added: New theme option menu named "Video Player"
* Added: New Video Resolutions fields (240p, 360p, 480p, 720p and 1080p) in the RetroTube - Video Information metabox
* Added: Listing of random videos in 404 or nothing found result search pages
* Updated: VideoJS video player replaced by FluidPlayer
* Updated: Webm format compatibility for video trailers
* Updated: Text for SEO option moved to homepage only to improve SEO (the option is now in Theme Options > Content > Homepage tab)
* Fixed: Minor bugs

= 1.1.6 = 2018-09-20
* Added: Number of photos per gallery in archive photos page
* Added: Photos loading message with counter
* Updated: Improvement of the waterfall effect loading
* Updated: Improvement of the photos archive displaying

= 1.1.5 = 2018-09-19
* Added: Improvement of the photos gallery displaying with waterfall effect
* Added: Lazy load on photos
* Added: Easy navigation between each photos
* Fixed: Minor bugs

= 1.1.4 = 2018-09-10
* Added: Video trailer as preview on mouse hover in your video listing
* Added: Video trailer URL field in the RetroTube - Video Information metabox
* Added: Preview of the video trailer in the RetroTube - Video Information metabox
* Added: New section "Blog" with possibility to add articles with categories and tags
* Added: New section "Photos" with possibility to add photos and create galleries
* Added: Lightbox system to open photos from a gallery
* Updated: Posts admin menu changed to Videos(for a better understanding)

= 1.1.3 = 2018-07-18
* Fixed: 404 pages issue

= 1.1.2 = 2018-07-04
* Added: Pagination for actors list
* Added: Full Width page template
* Added: Possibility to edit views and likes for each post in the Video Information metabox
* Added: Author, title and description video itemprop infos
* Added: Tags and actors in video submission form for users
* Added: New option to choose Aspect ratios of thumbnails (16/9 or 4/3)
* Added: New option to choose Main thumbnail quality (basic, normal or fine)
* Added: New option to choose the position of category description (top or bottom of the page)
* Added: New option to set the same link for every tracking buttons in video pages
* Added: New option to choose the "Actors" label in video pages
* Added: New option to add text in the footer to improve SEO
* Added: New option to choose the number of actors per page
* Fixed: Popular videos list display issue when no rated videos
* Fixed: Loading of social metas outside the video pages
* Fixed: Video information metabox displayed in page edition
* Fixed: Minor bugs

= 1.1.1 = 2018-04-24
* Added: Alt and Title tags with site name on logo image to improve SEO
* Updated: All advertising locations are now compatible with Ad Rotate plugin shortcodes
* Fixed: Space issue between tags
* Fixed: PHP Warnings generated by the Rates function
* Fixed: Preventing visitors to vote multiple times on videos

= 1.1.0 = 2018-04-09
* Added: Option to choose number of videos per page on mobile device
* Added: HD video switch option in the RetroTube - Video information metabox. Displays a HD label over the thumbnail
* Updated: Names of advertising block class to avoid AdBroker issue
* Updated: Advertising locations are now compatible with Ad Rotate plugin shortcodes
* Updated: Improved display of blocks on video pages in mobile mode
* Fixed: Opening featured videos displayed from the carousel on Firefox
* Fixed: Login/Register popup display issue with navigation
* Fixed: CSS version that didn't change preventing to see CSS changes when updating the theme

= 1.0.9 = 2018-03-27
* Fixed: Post format query issue
* Fixed: In-video width banner display issue
* Fixed: Views counting with some cache plugins

= 1.0.8 = 2018-03-20
* Added: Possibility to upload an image for actors
* Added: Integration of tags and actors fields in the frontend Video Submission form
* Added: Blog template page which allow you to create a separate blog page with "standard" posts
* Added: Create Blog page button in the theme options tools
* Added: Video preview for embed code section in the video information metabox (post admin)
* Added: Mobile section in the theme options with 2 tabs General and Advertising
* Added: Option to choose the number of videos per row on mobile
* Added: Option to choose if you want to disable or keep widgets on your homepage on mobile
* Added: Filters in tag and search page results
* Added: Instagram social share profile option in the top bar
* Updated: Duration field changed to HH MM SS in the video information metabox (post admin)
* Updated: Actors template page with images
* Updated: Menu on desktop and mobile improvement
* Updated: Unique banner under the video player displayed on mobile devices too
* Updated: Design improvement of the social buttons in the top bar
* Fixed: Twitter sharing with image, title and description
* Fixed: Facebook sharing with image, title and description
* Fixed: Slogan not visible when logo too big
* Fixed: Filters and pagination issue
* Fixed: Views and likes compatible with cache plugins
* Fixed: Sidebar displaying issue on mobile
* Fixed: Footer menu displaying
* Fixed: Description content displaying on mobile
* Fixed: Share buttons displaying on mobile
* Fixed: Minor bugs

= 1.0.7 = 2018-01-16
* Added: Possibility to display a unique banner under the video player for each post
* Added: Option to enable or not related videos
* Added: Option to set the number of related videos
* Added: Show more related videos button displayed under the related videos listing
* Added: Possibility to set an image for each category
* Added: Option to choose if you want to display or not a comments section in your single video pages.
* Added: Option to choose if you want to display or not the carousel of featured videos on mobile devices.
* Added: Option to choose if you want to display or not the sidebar on mobile devices.
* Added: Footer menu
* Updated: Custom CSS option removed. Compatibility with the additional CSS option in the WordPress customizer
* Updated: Translation pot file expressions
* Updated: Video URL preview in the Video Information metabox with YouTube, Google Drive and the most popular adult tubes
* Fixed: Close button on in-video advertising which passed behind the banners
* Fixed: Submit a video form redirection issue from some server
* Fixed: Minor bugs

= 1.0.6 = 2017-12-02
* Fixed: Fatal error on single video pages with some PHP versions

= 1.0.5 = 2017-12-01
* Added: Option to enable / disable thumbnails rotation
* Added: Possibility to display your Tumblr social profile link in the topbar
* Updated: Improvement of the read more feature for truncate descriptions
* Updated: Lazy load feature
* Fixed: Thumbnails used for rotation saving during a manual post creation
* Fixed: Tracking URL button displaying issue in mobile version
* Fixed: Comments fields displaying in mobile version
* Fixed: In-video banners size
* Fixed: Minor bugs

= 1.0.4 = 2017-11-21
* Fixed: Inside video player advertising width display issue

= 1.0.3 = 2017-11-21
* Fixed: Pornhub, Redtube, Spankwire, Tube8, Xhamster, Xvideos and Youporn embed player displaying issue when the URL of the video was saved in Video URL field.
* Fixed: Minor bugs

= 1.0.2 = 2017-11-17
* Added: VK sharing button on single video pages
* Fixed: Fatal error on single video pages with some PHP versions
* Fixed: Issue with login / register system when "Anyone can register" option was disabled
* Fixed: Minor bugs

= 1.0.1 = 2017-11-08
* Fixed: Inside video player advertising display issue

= 1.0.0 = 2017-10-30
* Added: Initial release

