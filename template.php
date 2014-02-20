<?php

function ncsulibraries_process_html(&$vars){
    foreach (array('head', 'styles', 'scripts', 'page_bottom') as $replace) {
        if (!isset($vars[$replace])) {
            continue;
        }

        $vars[$replace] = preg_replace('/(src|href|@import )(url\(|=)(")http(s?):/', '$1$2$3', $vars[$replace]);
    }
}

/**
 * Setting custom variable htdocs root path
 */
variable_set('htdocs_root', str_replace(strrchr(DRUPAL_ROOT, "/"), "/htdocs", DRUPAL_ROOT));

/**
 *  Implements template_preprocess_page()
 *
 *  The code below handles additional page template/CSS suggestions in Drupal
 *  and other various and sundry activities
 */
function ncsulib_foundation_preprocess_page(&$variables) {
    if (module_exists('path')) {
        $alias = drupal_get_path_alias(str_replace('/edit','',$_GET['q']));
        // If the alias is a clean URL
        if ($alias != $_GET['q'] || empty($variables['node'])) {
            // Break the alias into its parts and iterate through the alias part by part
            $i=0;
            foreach (explode('/', $alias) as $path_part) {
                if ($i==0) {
                    // If this is the first time through the loop, create the template suggestion
                    $template_suggestion = $path_part;
                    $css_suggestion = $path_part;
                } elseif ($i>=1) {
                    if ($i==1) {
                        // If this is the second time through the loop, create a variable to append each $path_part to
                        $path_part_holder = $css_suggestion . '--' . $path_part;
                    } elseif ($i>=2) {
                        $path_part_holder .= '--' . $path_part;
                    }

                    // If this is the second time or more through the loop, continue to append the alias path to the template suggestion
                    $template_suggestion = $template_suggestion . '__' . $path_part;
                    $css_suggestions[] = $path_part_holder;
                }
                $i++;
            }

            $template_suggestion = 'page__' . $template_suggestion;
            // Add the template suggestion to the template suggestions hook
            $variables['theme_hook_suggestions'][] = $template_suggestion;
        }

    // Create the CSS suggestion(s)
    if (isset($css_suggestion)) {
      $css_suggestion = path_to_theme() .'/styles/'. $css_suggestion .'.css';
      // CSS suggestion for the top level alias path
      $include_style[] = $css_suggestion;
      // If the page resides at a deep level and more specific CSS is desired,
      // add more specific page CSS suggestions
      if (isset($css_suggestions)) {
        foreach ($css_suggestions as $suggestion) {
          $include_style[] = path_to_theme() .'/styles/'. $suggestion .'.css';
        }
      }
    }

    // If this is the front/home page of the site
    if ($variables['is_front']) {

      // Add the following Conditional CSS suggestions to Drupal
      drupal_add_css(path_to_theme() . '/styles/ie7.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
      drupal_add_css(path_to_theme() . '/styles/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));

      function ncsulib_foundation_css_alter(&$css) {
          $css['sites/all/themes/ncsulib_foundation/styles/core/ncsulib_foundation.css']['weight'] = -1;
// kpr($css);

        // Remove unused CSS files for performance
        if (isset($css['modules/aggregator/aggregator.css'])) {
          unset($css['modules/aggregator/aggregator.css']);
        }
        if (isset($css['modules/book/book.css'])) {
          unset($css['modules/book/book.css']);
        }
        if (isset($css['modules/field/theme/field.css'])) {
          unset($css['modules/field/theme/field.css']);
        }
        if (isset($css['modules/node/node.css'])) {
          unset($css['modules/node/node.css']);
        }
        if (isset($css['modules/system/system.messages.css'])) {
          unset($css['modules/system/system.messages.css']);
        }
        if (isset($css['modules/user/user.css'])) {
          unset($css['modules/user/user.css']);
        }
        if (isset($css['sites/all/modules/ctools/css/ctools.css'])) {
          unset($css['sites/all/modules/ctools/css/ctools.css']);
        }
        if (isset($css['sites/all/modules/mollom/mollom.css'])) {
          unset($css['sites/all/modules/mollom/mollom.css']);
        }
        if (isset($css['sites/all/modules/views/css/views.css'])) {
          unset($css['sites/all/modules/views/css/views.css']);
        }
        if (isset($css['sites/all/modules/views_slideshow/views_slideshow.css'])) {
          unset($css['sites/all/modules/views_slideshow/views_slideshow.css']);
        }
      }
    }

    // If there are CSS suggestions to include
    if (isset($include_style)) {
      foreach ($include_style as $included_styles) {
        //Add the CSS suggestion to Drupal
        drupal_add_css($included_styles);
      }
    }
  }


  // Creating a single template suggestion for all pages that begin with /scrc
  // allowing for overrides by more specific path-based or node id templates
  // e.g. page--scrc--zoologicalhealth.tpl.php or page--node--9999.tpl.php
  if (preg_match('/^scrc/', $alias)){
    $arr_length = count($variables['theme_hook_suggestions']);
    array_splice($variables['theme_hook_suggestions'], ($arr_length-2), 0, 'page__scrc__subpage');
  }

  // Add sidebard detector to the node object
  if(!empty($variables['page']['sidebar_first'])){
    $node_id = key($variables['page']['content']['system_main']['nodes']);
    $variables['page']['content']['system_main']['nodes'][$node_id]['#node']->sidebar_first = TRUE;
  }

} // End tremendous template_preprocess_page function

/**
 * Implements theme_breadrumb().
 *
 * Print breadcrumbs as a list, with separators.
 * Note: this was a default hook that came packaged with the Zurb Foundation
 * child theme
 */
function ncsulib_foundation_breadcrumb($variables) {
  $links = array();
  $path = '';
  // Get URL arguments
  $arguments = explode('/', request_uri());
  // Remove empty values
  foreach ($arguments as $key => $value) {
    if (empty($value)) {
      unset($arguments[$key]);
    }
  }
  $arguments = array_values($arguments);
  // Add 'Home' link
  $links[] = l(t('Home'), '<front>');
  // Add other links
  if (!empty($arguments)) {
    foreach ($arguments as $key => $value) {
      // Don't make last breadcrumb a link
      if ($key == (count($arguments) - 1)) {
        $links[] = drupal_get_title();
      } else {
        if (!empty($path)) {
          $path .= '/'. $value;
        } else {
          $path .= $value;
        }
        $links[] = l(drupal_ucfirst($value), $path);
      }
    }
  }
  // Set custom breadcrumbs
  drupal_set_breadcrumb($links);
  // Get custom breadcrumbs
  $breadcrumb = drupal_get_breadcrumb();

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $breadcrumbs = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $breadcrumbs .= '<ul class="breadcrumbs">';

    foreach ($breadcrumb as $key => $value) {
      $breadcrumbs .= '<li>' . $value . '</li>';
    }

    $title = strip_tags(drupal_get_title());
    // $breadcrumbs .= '<li class="current"><a href="#">' . $title. '</a></li>';
    $breadcrumbs .= '</ul>';

    return $breadcrumbs;
  }
}

function ncsulibraries_form_user_login_alter(&$form, &$form_state, $form_id) {
  //Alters the text on the user login form
  drupal_set_title(t('Website editing login'));
  $form['name']['#title'] = t('Unity ID');
  $form['name']['#description'] = t('Enter your NCSU Unity ID');
  $form['pass']['#title'] = t('Active Directory password');
  $form['pass']['#description'] = t('Enter your NCSU Libraries Active Directory password');
}

function ncsulibraries_more_link ($array) {
  if (stristr($array['url'], 'aggregator')) {
    return "";
  }
}

/**
 *  Blocks preprocessor
 *
 *  Handles adding additional classes to the blocks on the "/upcomingevents"
 *  page.
 *  Adds classes to blocks on the scrc page.
 *
 *  -Charlie Morris 11/20/2012
 */
function ncsulibraries_preprocess_block(&$variables) {
  if ($variables['block_html_id'] == 'block-views-upcoming-events-block-3') {
    $variables['classes_array'][] = 'grid-12';
    $variables['classes_array'][] = 'alpha';
    $variables['classes_array'][] = 'omega';
    // $variables['elements']['#block']->subject = date('l, M jS', strtotime('today'));
  }
  // adding classes to blocks on /scrc
  if ($variables['block_html_id']  == "block-aggregator-feed-8") {
    $variables['classes_array'][] = 'grid-12';
    $variables['classes_array'][] = 'alpha';
  }
  if ($variables['block_html_id']  == "block-block-78"){
    $variables['classes_array'][] = 'grid-4';
    $variables['classes_array'][] = 'omega';
  }
}

/**
 * Modify the output of views
 *
 * -Charlie Morris, 1/2/13
 */
function ncsulibraries_views_pre_render(&$view) {
  // The following two loops add month and day formatted dates to events
  if ($view->name == 'upcoming_events' && $view->current_display == 'block_3') {
    if (!empty($view->result)) {
      for ($i = 0; $i < count($view->result); $i++ ) {
        // Set event url
        $node = node_load($view->result[$i]->nid);
        $url_data = field_get_items('node', $node, 'field_event_url');
        $alias = drupal_get_path_alias('node/'.$node->nid);
        if(!empty($url_data[0]['url'])) {
          $view->result[$i]->event_url = $url_data[0]['url'];
        } else if ($alias){
          $view->result[$i]->event_url = $alias;
        } else {
          $view->result[$i]->event_url = '/node/'.$view->result[$i]->nid;
        }

        // Set event dates
        $timestamp = filter_xss($view->result[$i]->field_data_field_time_field_time_value);
        $timestamp2 = filter_xss($view->result[$i]->field_data_field_time_field_time_value2);
        $open = strtotime($timestamp)+ncsulibraries_adjust_for_timezone($timestamp);
        $close = strtotime($timestamp2)+ncsulibraries_adjust_for_timezone($timestamp2);
        $view->result[$i]->date_display = (date('m j Y', $open) == date('m j Y', $close)) ? date('M j, Y', $open) : date('M j, Y', $open) . ' - ' . date('M j, Y', $close);
      }
    }
  }

  // Add stylesheet to make the related devices on tech categories look right
  if ($view->name == 'devices_device' && $view->current_display == 'block_9') {
    drupal_add_css(path_to_theme() . '/styles/related_devices.css');
  }

  // Add stylesheet to cover all dataviews block displays
  if ($view->name == "dv_hours_open") {
    drupal_add_css(path_to_theme() . '/styles/dataviews.css');
  }


}

/**
 * Returns HTML for an individual feed item for display in the block.
 *
 * Author: Charlie Morris
 * For SCRC
 */
function ncsulibraries_aggregator_block_item($variables) {
  if ($variables['item']->fid == '8') {
    // Display the external link to the item.
    return '<a href="' . check_url($variables['item']->link) . '">' . check_plain($variables['item']->title) . "</a>\n<br />" . filter_xss($variables['item']->description);
  } else {
    return '<a href="' . check_url($variables['item']->link) . '">' . check_plain($variables['item']->title) . "</a>\n";
  }
}

/**
 * Implements template_preprocess_image
 *
 * Image preprocessor
 *
 * Author: Charlie Morris
 *
 */
function ncsulibraries_preprocess_image(&$variables) {
  // Only perform preprocessing on images with defined style
  if (isset($variables['style_name'])) {
    // Add the image-outline style for images with half-page-width style
    // applied
    if ($variables['style_name'] == 'half-page-width') {
      $variables['attributes']['class'][] = 'image-outline';
    }
  }
}

/**
 * Implements theme_field()
 *
 * Using this to change the markup delivered to the Field Request Form URL
 * field.  Turning it into a button.
 */
function ncsulibraries_field__field_request_form_url__device($variables) {
  $output ='';
  $device_nid = $variables['element']['#object']->nid;
  $building = " (Hill only)";

  foreach ($variables['items'] as $delta => $item) {
    if ($device_nid == 22470 ) {
      // 22470 = Canon EOS Rebel T4i
      $building = " (Hunt only)";
    } else if ($device_nid == 23583){
      // 23583 = projectors
      $building = '';
    }
    $output = '<div class="clear-left"><a href="'.drupal_render($item).'" class="reserve-button">Request'.$building.'</a></div>';
  }
  return $output;
}

/**
 * Implements theme_field()
 *
 * Using this to change the markup delivered to the Building field on Space
 * nodes
 */
function ncsulibraries_field__field_building_name__space($variables) {
  $output ='';
  foreach ($variables['items'] as $delta => $item) {
    $output = drupal_render($item);
  }
  return $output;
}

/**
 * Implements theme_field()
 *
 * Adding heading 2 for label
 */
function ncsulibraries_field__space($variables) {
  $output = '';

  // Render the label, if it's not hidden and display it as a heading 2
  if (!$variables['label_hidden']) {
    $output .= '<h2' . $variables['title_attributes'] . '>' . $variables['label'] . '</h2>';
  }

  // Render the items.
  $output .= '<div class="field-items"' . $variables['content_attributes'] . '>';
  foreach ($variables['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<div class="' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
  }
  $output .= '</div>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . '</div>';

  return $output;
}

/**
 * Helper function that adjusts date to current timezone. Especially for
 * daylight savings
 */
function ncsulibraries_adjust_for_timezone($time){
    $origin_dtz = new DateTimeZone(date_default_timezone_get());
    $origin_dt = new DateTime($time, $origin_dtz);
    return $origin_dtz->getOffset($origin_dt);
}

