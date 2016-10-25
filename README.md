This version was discontinued, please upgrade to V2
================

**New version:** https://github.com/airesvsg/acf-to-rest-api/

ACF to WP REST API
================
Puts ACF data into the WP-REST-API ( WP-API | WordPress JSON API ).
Also you can customize the answer using filters.

Installation
================
1. Copy the `acf-to-wp-rest-api` folder into your `wp-content/plugins` folder
2. Activate the `ACF to WP REST API` plugin via the plugins admin page

Get ACF data by ID
================
- /wp-json/acf/post/`<ID>`
- /wp-json/acf/page/`<ID>`
- /wp-json/acf/user/`<ID>`
- /wp-json/acf/term/`<ID>`/`<TAXONOMY>`
- /wp-json/acf/comment/`<ID>`
- /wp-json/acf/attachment/`<ID>`

Get Options
================
- /wp-json/acf/`options`

Get Option by Field Name
================
- /wp-json/acf/options/`<FIELD_NAME>`

Sample Answer
================
```json
{
  "ID" : 1,
  "post_title" : "Post 1",
  "..."
  "acf" : {
    "field1" : "value 1",
    "field2" : "value 2"
  }
}
```

Filter
================
Use the filter (**acf_to_wp_rest_api_`{type}`_data**) to customize the answer.

The wildcard `{type}` can be: **post**, **page**, **user**, **term**, **comment**, **attachment** or **options**

#### How to use
```PHP
add_filter( 'acf_to_wp_rest_api_post_data', function( $data, $object, $context ) {
    if ( isset( $data['type'] ) && 'my_post_type' == $data['type'] && isset( $data['acf'] ) ) {
      // do something
    }
    return $data;
}, 10, 3 );
```
