ACF to WP REST API
================
Puts in answers all fields of ACF.

Installation
================
1. Copy the `acf-to-wp-rest-api` folder into your `wp-content/plugins` folder
2. Activate the `ACF to WP REST API` plugin via the plugins admin page

Get ACF data by ID
================
- /wp-json/acf/post/`<ID>`
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