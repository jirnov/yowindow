<?php
/*
Plugin Name: YoWindow Widget Plugin
Plugin URI: http://blog2k.ru/yowindow/
Author: Evgenii Zhirnov <evgeny@blog2k.ru>
Author URI: http://blog2k.ru/
Description: YoWindow Widget Plugin
Version: 0.0.4
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class YoWindowWidget extends WP_Widget {

    private static $defaults = array(
        'title' => 'YoWindow Weather',
        'city' => 'Saint-Petersburg',
        'location_id' => '498817',
        'landscape' => 'village',
        'language' => 'ru',
        'width' => 200,
        'auto_width' => 'off',
        'height' => 200,
        'time_format' => '24',
        'action' => 'window',
        'mini_temperature' => 'on',
        'mini_time' => 'on',
        'location_bar' => 'on',
        'time_bar' => 'on',
        'unit_system' => 'metric',
        'u_temperature' => 'c',
        'u_wind_speed' => 'kph',
        'u_pressure' => 'hpa',
        'u_pressure_level' => 'sea',
        'u_distance' => 'km',
        'u_rain_rate' => 'mm',
        'hide_if_mobile' => 'off',
        'background' => '#FFFFFF'
    );

    private static $landscape = array(
        'village' => 'Village',
        'valley' => 'Valley',
        'seaside' => 'Seaside',
        'airport' => 'Airport',
        'oriental' => 'Oriental',
        'town' => 'Town',
        'random' => 'Random'
    );

    private static $time_format = array(
        '12' => 'AM/PM',
        '24' => '24 hours'
    );

    private static $action = array(
        'full_screen' => 'Full screen',
        'window' => 'Visit YoWindow.com'
    );

    private static $language = array(
        'en' => 'English',
        'es' => 'Español',
        'bg' => 'Български',
        'bs' => 'Bosanski',
        'ca' => 'Català',
        'cs' => 'Čeština',
        'da' => 'Dansk',
        'de' => 'Deutsch',
        'fr' => 'Français',
        'el' => 'Ελληνικά',
        'et' => 'Eesti',
        'hr' => 'Hrvatski',
        'it' => 'Italiano',
        'lt' => 'Lietuvių',
        'lv' => 'Latviešu',
        'hu' => 'Magyar',
        'nl' => 'Nederlands',
        'no' => 'Norsk ',
        'ru' => 'Русский',
        'pl' => 'Polski',
        'pt' => 'Português',
        'br' => 'Português ',
        'ro' => 'Română',
        'sk' => 'Slovak',
        'sq' => 'Shqip',
        'fi' => 'Suomi',
        'sv' => 'Svenska',
        'tr' => 'Türkçe',
        'sr' => 'Српски',
        'mk' => 'Македонски',
        'sl' => 'Slovenčina',
        'uk' => 'Українська',
        'cn' => '中文 ',
        'ja' => '日本語',
        'ko' => '한국어',
    );

    private static $unit_system = array(
        'us' => array(
            'name' => 'US',
            'u_temperature' => 'f',
            'u_wind_speed'  => 'mph',
            'u_pressure' => 'in',
            'u_pressure_level' => 'sea',
            'u_distance' => 'mile',
            'u_rain_rate' => 'in'
        ),
        'metric' => array(
            'name' => 'Metric',
            'u_temperature' => 'c',
            'u_wind_speed'  => 'kph',
            'u_pressure' => 'hpa',
            'u_pressure_level' => 'sea',
            'u_distance' => 'km',
            'u_rain_rate' => 'mm'
        ),
        'uk' => array(
            'name' =>'UK',
            'u_temperature' => 'c',
            'u_wind_speed'  => 'mph',
            'u_pressure' => 'mbar',
            'u_pressure_level' => 'sea',
            'u_distance' => 'km',
            'u_rain_rate' => 'mm'
        ),
        'finland' => array(
            'name' => 'Finland',
            'u_temperature' => 'c',
            'u_wind_speed'  => 'mps',
            'u_pressure' => 'hpa',
            'u_pressure_level' => 'sea',
            'u_distance' => 'km',
            'u_rain_rate' => 'mm'
        ),
        'russia' => array(
            'name' => 'Russia',
            'u_temperature' => 'c',
            'u_wind_speed'  => 'mps',
            'u_pressure' => 'mm',
            'u_pressure_level' => 'location',
            'u_distance' => 'km',
            'u_rain_rate' => 'mm'
        ),
        'custom' => array(
            'name' => 'Custom...',
            'u_temperature' => 'f',
            'u_wind_speed'  => 'mps',
            'u_pressure' => 'mm',
            'u_pressure_level' => 'location',
            'u_distance' => 'miles',
            'u_rain_rate' => 'mm'
        ),
    );

    private static $u_temperature = array(
        'c' => '°C',
        'f' => '°F',
    );

    private static $u_wind_speed = array(
        'kph' => 'kph',
        'mph' => 'mph',
        'mps' => 'mps',
        'knot' => 'knots',
        'beaufort' => 'Beaufort'
    );

    private static $u_pressure = array(
        'hpa' => 'hPa',
        'kpa' => 'kPa',
        'in' => '"',
        'mm' => 'mm',
        'mbar' => 'mb'
    );

    private static $u_pressure_level = array(
        'sea' => 'sea level',
        'location' => 'location level',
    );

    private static $u_distance = array(
        'mile' => 'miles',
        'km' => 'km'
    );

    private static $u_rain_rate = array(
        'in' => '"',
        'mm' => 'mm',
        'cm' => 'cm'
    );

    private $data_uri = "http://swf.yowindow.com/yowidget3.swf";

    private static $widget_form =
'<div style="width:%width%;height:%height%px;">
    <object type="application/x-shockwave-flash" data="%data_uri%" width="%width%" height="%height%px">
        <param name="movie" value="%data_uri%"/>
        <param name="allowfullscreen" value="true"/>
        <param name="wmode" value="opaque"/>
        <param name="bgcolor" value="%bgcolor%"/>
        <param name="flashvars" value="%flashvars%" />
        <a href="http://WeatherScreenSaver.com?client=widget&amp;link=copyright" style="width:100%;height:%height%px;display: block;text-indent: -50000px;font-size: 0px;background:#DDF url(http://yowindow.com/img/logo.png) no-repeat scroll 50% 50%;">Free Weather Widget</a>
    </object>
</div>
<div style="width:%width%;height: 15px; font-size: 14px; font-family: Arial,Helvetica,sans-serif;">
    <span style="float:left;">
        <a target="_top" href="http://WeatherScreenSaver.com?client=widget&amp;link=copyright" style="color: #2fa900; font-weight:bold; text-decoration:none;" title="Screen Saver">YoWindow.com</a>
    </span>
    <span style="float:right; color:#888888;">
        <a href="http://yr.no" style="color: #2fa900; text-decoration:none;">yr.no</a>
    </span>
</div>';

    function YoWindowWidget() {
        // Instantiate the parent object
        parent::__construct(
            'yowindow_widget',
            __('YoWindow widget', 'yo'),
            array( 'description' => __('Display YoWindow weather widget.', 'yo')));

        self::$defaults['language'] = substr(get_bloginfo('language'), 0, 2);
        self::$defaults['title'] = __('YoWindow Weather', 'yo');
        self::$defaults['city'] = __('Saint-Petersburg', 'yo');

        if (file_exists(plugin_dir_path(__FILE__) . 'yowindow/yowidget.swf')) {
            $this->data_uri = plugin_dir_url(__FILE__) . "yowindow/yowidget.swf";
        }
    }

    function get_landscape($instance) {
        if ('random' == $instance['landscape']) {
            $items = array_keys(self::$landscape);
            return $items[date('z') % (count($items) - 1)];
        }
        return $instance['landscape'];
    }


    function get_bool($instance, $key) {
        return ($instance[$key] == 'on') ? 'true' : 'false';
    }


    function is_mobile() {
        if (!function_exists('jetpack_is_mobile')) {
            return false;
        }

        if (isset($_COOKIE['akm_mobile']) && $_COOKIE['akm_mobile'] == 'false') {
            return false;
        }  
        return jetpack_is_mobile();
    }


    function widget( $args, $instance ) {
        extract($args);

        $instance = wp_parse_args($instance, self::$defaults);

        if ($this->get_bool($instance, 'hide_if_mobile') && $this->is_mobile()) {
            return;
        }
        
        $flashvars = "";
        $flashvars .= esc_html("copyright_bar=false");
        $flashvars .= esc_html("&background=" . $instance['background']);
        $flashvars .= esc_html("&landscape=" . $this->get_landscape($instance));
        $flashvars .= esc_html("&lang=" . $instance['language']);
        $flashvars .= esc_html("&location_id=gn:" . $instance['location_id']);
        $flashvars .= esc_html("&location_name=" . $instance['city']);
        $flashvars .= esc_html("&time_format=" . $instance['time_format']);
        $flashvars .= esc_html("&unit_system=" . $instance['unit_system']);
        $flashvars .= esc_html("&mini_action=" . $instance['action']);
        $flashvars .= esc_html("&mini_temperature=" . $this->get_bool($instance, 'mini_temperature'));
        $flashvars .= esc_html("&mini_time=" . $this->get_bool($instance, 'mini_time'));
        $flashvars .= esc_html("&mini_locationBar=" . $this->get_bool($instance, 'location_bar'));
        $flashvars .= esc_html("&mini_momentBar=" . $this->get_bool($instance, 'time_bar'));

        if ('custom' == $instance['unit_system']) {
            $flashvars .= esc_html("&u_temperature=" . $instance['u_temperature']);
            $flashvars .= esc_html("&u_wind_speed=" . $instance['u_wind_speed']);
            $flashvars .= esc_html("&u_pressure=" . $instance['u_pressure']);
            $flashvars .= esc_html("&u_pressure_level=" . $instance['u_pressure_level']);
            $flashvars .= esc_html("&u_distance=" . $instance['u_distance']);
            $flashvars .= esc_html("&u_rain_rate=" . $instance['u_rain_rate']);
        }

        $o = "" . self::$widget_form;
        $o = str_replace('%data_uri%', $this->data_uri, $o);
        $o = str_replace('%flashvars%', $flashvars, $o);
        $width = $this->get_bool($instance, 'auto_width') ? '100%' : $instance['width'] . 'px';
        $o = str_replace('%width%', $width, $o);
        $o = str_replace('%height%', $instance['height'], $o);
        $o = str_replace('%bgcolor%', $instance['background'], $o);

        $output = $before_widget;
        if (!empty($instance['title'])) {
            $output .= $before_title;
            $output .= esc_html($instance['title']);
            $output .= $after_title;
        }
        $output .= $o;
        $output .= $after_widget;

        echo "\n<!-- YoWindow Widget begin -->\n";
        echo $output;
        echo "\n<!-- YoWindow Widget end -->\n";
    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
        extract($new_instance);

        $instance = $old_instance;
        $instance['title'] = strip_tags($title);
        $instance['language'] = strip_tags($language);
        $instance['city'] = strip_tags($city);
        $instance['location_id'] = strip_tags($location_id);
        $instance['landscape'] = strip_tags($landscape);
        $instance['width'] = intval($width);
        $instance['auto_width'] = strip_tags($auto_width);
        $instance['height'] = intval($height);
        $instance['time_format'] = strip_tags($time_format);
        $instance['action'] = strip_tags($action);
        $instance['mini_temperature'] = strip_tags($mini_temperature);
        $instance['mini_time'] = strip_tags($mini_time);
        $instance['location_bar'] = strip_tags($location_bar);
        $instance['time_bar'] = strip_tags($time_bar);

        $instance['unit_system'] = strip_tags($unit_system);
        $instance['u_temperature'] = strip_tags($u_temperature);
        $instance['u_wind_speed'] = strip_tags($u_wind_speed);
        $instance['u_pressure'] = strip_tags($u_pressure);
        $instance['u_pressure_level'] = strip_tags($u_pressure_level);
        $instance['u_distance'] = strip_tags($u_distance);
        $instance['u_rain_rate'] = strip_tags($u_rain_rate);

        $instance['hide_if_mobile'] = strip_tags($hide_if_mobile);
        $instance['background'] = strip_tags($background);

        return $instance;
    }


    function form( $instance ) {
        $instance = wp_parse_args($instance, self::$defaults);

        extract($instance);

        $fields = implode(',', array(
            $this->get_field_name('u_temperature'),
            $this->get_field_name('u_wind_speed'),
            $this->get_field_name('u_pressure'),
            $this->get_field_name('u_pressure_level'),
            $this->get_field_name('u_distance'),
            $this->get_field_name('u_rain_rate')
        ));
           
        ?>

        <script type="text/javascript">
        <?php 
        echo "var yoUnits = {";
        foreach (self::$unit_system as $value => $display ) {
            if ('custom' == $value) {
                continue;
            }
            echo "'" . $value . "' : {";
            echo "'temperature' : '" . self::$unit_system[$value]['u_temperature'] . "', ";
            echo "'wind_speed' : '" . self::$unit_system[$value]['u_wind_speed'] . "', ";
            echo "'pressure' : '" . self::$unit_system[$value]['u_pressure'] . "', ";
            echo "'pressure_level' : '" . self::$unit_system[$value]['u_pressure_level'] . "', ";
            echo "'distance' : '" . self::$unit_system[$value]['u_distance'] . "', ";
            echo "'rain_rate' : '" . self::$unit_system[$value]['u_rain_rate'] . "', ";
            echo "},";
        } 
        echo "}\n";
        ?>
        </script>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'City name:', 'yo' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" type="text" value="<?php echo esc_attr( $city ); ?>" class="widefat">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('location_id'); ?>"><?php _e('Location Id:', 'yo'); echo ' (<a href="http://yowindow.com/id.php?from=wordpress" target="blank">' . __('get location id', 'yo') . '</a>)'; ?></label>
            <input id="<?php echo $this->get_field_id( 'location_id' ); ?>" name="<?php echo $this->get_field_name( 'location_id' ); ?>" type="text" value="<?php echo esc_attr( $location_id ); ?>" class="widefat">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('landscape'); ?>"><?php _e('Landscape: ', 'yo'); ?></label>
            <select id="<?php echo $this->get_field_id('landscape'); ?>" name="<?php echo $this->get_field_name('landscape'); ?>" class="widefat"><?php
            foreach (self::$landscape as $value => $display ) {
                $selected = selected($value, $landscape, false);
                echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
            }?>
           </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('language'); ?>"><?php _e('Language:', 'yo'); ?></label>
            <select id="<?php echo $this->get_field_id('language'); ?>" name="<?php echo $this->get_field_name('language'); ?>" class="widefat"><?php
            foreach (self::$language as $value => $display ) {
                $selected = selected($value, $language, false);
                echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
            }?>
           </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'yo'); ?></label>
            <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" class="widefat">
            <br>
            <input id="<?php echo $this->get_field_id('auto_width');?>" name="<?php echo $this->get_field_name('auto_width')?>" type="checkbox" <?php checked($auto_width, 'on');?>>
            <label for="<?php echo $this->get_field_id('auto_width'); ?>"><?php _e('Stretch to widget area width', 'yo');?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'yo'); ?></label>
            <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('time_format'); ?>"><?php _e('Time format:', 'yo')?></label>
            <select id="<?php echo $this->get_field_id('time_format'); ?>" name="<?php echo $this->get_field_name('time_format'); ?>" class="widefat"><?php
            foreach (self::$time_format as $value => $display ) {
                $selected = selected($value, $time_format, false);
                echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
            }?>
           </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('unit_system'); ?>"><?php _e('Units:', 'yo')?></label>
            <select id="<?php echo $this->get_field_id('unit_system'); ?>" name="<?php echo $this->get_field_name('unit_system'); ?>" class="widefat" onchange="javascript: onChangeUnits(this.options[this.selectedIndex].value, '<?php echo $fields;?>');"><?php
            foreach (self::$unit_system as $value => $display ) {
                $selected = selected($value, $unit_system, false);
                echo "<option value='" . esc_attr($value) . "'" .  $selected . ">" . __($display['name'], 'yo') . "</option>\n";
            }?>
            </select>
            <table>
                <tr>
                    <td><label for="<?php echo $this->get_field_id('u_temperature');?>"><?php echo __('Temperature', 'yo').':';?></label></td>
                    <td><select id="<?php echo $this->get_field_id('u_temperature');?>" name="<?php echo $this->get_field_name('u_temperature'); ?>" onchange="javascript: onSelectCustomUnits('<?php echo $this->get_field_name("unit_system");?>');"><?php
                    foreach (self::$u_temperature as $value => $display) {
                        $selected = selected($value, $u_temperature, false);
                        echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                    } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="<?php echo $this->get_field_id('u_wind_speed');?>"><?php echo __('Wind speed:', 'yo');?></label></td>
                    <td><select id="<?php echo $this->get_field_id('u_wind_speed');?>" name="<?php echo $this->get_field_name('u_wind_speed'); ?>" onchange="javascript: onSelectCustomUnits('<?php echo $this->get_field_name("unit_system");?>');"><?php
                    foreach (self::$u_wind_speed as $value => $display) {
                        $selected = selected($value, $u_wind_speed, false);
                        echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                    } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="<?php echo $this->get_field_id('u_pressure');?>"><?php echo __('Pressure:', 'yo');?></label></td>
                    <td><select id="<?php echo $this->get_field_id('u_pressure');?>" name="<?php echo $this->get_field_name('u_pressure'); ?>" onchange="javascript: onSelectCustomUnits('<?php echo $this->get_field_name("unit_system");?>');"><?php
                    foreach (self::$u_pressure as $value => $display) {
                        $selected = selected($value, $u_pressure, false);
                        echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                    } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="<?php echo $this->get_field_id('u_pressure_level');?>"><?php echo __('Display pressure for:', 'yo');?></label></td>
                    <td><select id="<?php echo $this->get_field_id('u_pressure_level');?>" name="<?php echo $this->get_field_name('u_pressure_level'); ?>" onchange="javascript: onSelectCustomUnits('<?php echo $this->get_field_name("unit_system");?>');"><?php
                    foreach (self::$u_pressure_level as $value => $display) {
                        $selected = selected($value, $u_pressure_level, false);
                        echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                    } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="<?php echo $this->get_field_id('u_distance');?>"><?php echo __('Distance:', 'yo');?></label></td>
                    <td><select id="<?php echo $this->get_field_id('u_distance');?>" name="<?php echo $this->get_field_name('u_distance'); ?>" onchange="javascript: onSelectCustomUnits('<?php echo $this->get_field_name("unit_system");?>');"><?php
                    foreach (self::$u_distance as $value => $display) {
                        $selected = selected($value, $u_distance, false);
                        echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                    } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="<?php echo $this->get_field_id('u_rain_rate');?>"><?php echo __('Rain/Snow rate:', 'yo');?></label></td>
                    <td><select id="<?php echo $this->get_field_id('u_rain_rate');?>" name="<?php echo $this->get_field_name('u_rain_rate'); ?>" onchange="javascript: onSelectCustomUnits('<?php echo $this->get_field_name("unit_system");?>');"><?php
                    foreach (self::$u_rain_rate as $value => $display) {
                        selected($value, $u_rain_rate, false);
                        echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                    } ?>
                    </select></td>
                </tr>
            </table>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('action'); ?>"><?php _e('Action:', 'yo')?></label>
            <select id="<?php echo $this->get_field_id('action'); ?>" name="<?php echo $this->get_field_name('action'); ?>" class="widefat"><?php
                foreach (self::$action as $value => $display ) {
                    $selected = selected($value, $action, false);
                    echo "<option value='" . esc_attr($value) . "'" . $selected . ">" . __($display, 'yo') . "</option>\n";
                }?>
            </select>
        </p>

        <p>
            <label><?php _e('Mini view:', 'yo'); ?></label><br>
            <input id="<?php echo $this->get_field_id('mini_temperature'); ?>" name="<?php echo $this->get_field_name('mini_temperature')?>" type="checkbox" <?php checked($mini_temperature, 'on'); ?> >
            <label for="<?php echo $this->get_field_id('mini_temperature'); ?>"><?php _e('Temperature', 'yo'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('mini_time'); ?>" name="<?php echo $this->get_field_name('mini_time')?>" type="checkbox" <?php checked($mini_time, 'on'); ?> >
            <label for="<?php echo $this->get_field_id('mini_time'); ?>"><?php _e('Time', 'yo'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('location_bar'); ?>" name="<?php echo $this->get_field_name('location_bar')?>" type="checkbox" <?php checked($location_bar, 'on'); ?> >
            <label for="<?php echo $this->get_field_id('location_bar'); ?>"><?php _e('Location bar', 'yo'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('time_bar'); ?>" name="<?php echo $this->get_field_name('time_bar')?>" type="checkbox" <?php checked($time_bar, 'on'); ?> >
            <label for="<?php echo $this->get_field_id('time_bar'); ?>"><?php _e('Time bar', 'yo'); ?></label>
        </p>

        <p>
            <input id="<?php echo $this->get_field_id('hide_if_mobile'); ?>" name="<?php echo $this->get_field_name('hide_if_mobile')?>" type="checkbox" <?php checked($hide_if_mobile, 'on'); ?> >
            <label for="<?php echo $this->get_field_id('hide_if_mobile'); ?>"><?php _e('Hide if Jetpack Mobile theme is shown', 'yo'); ?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background color:', 'yo'); ?></label>
            <input id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" type="text" value="<?php echo $background; ?>" class="widefat">
        </p>

        <?php
    }
}


function yo_register_widgets() {
    load_plugin_textdomain('yo', false, dirname(plugin_basename(__FILE__)).'/languages');
    register_widget( 'YoWindowWidget' );
}

add_action( 'widgets_init', 'yo_register_widgets' );


function yo_enqueue_scripts() {
    wp_enqueue_script('yowindow-widget', plugin_dir_url(__FILE__) . 'yowindow-widget.js');
    
}
add_action( 'admin_enqueue_scripts', 'yo_enqueue_scripts');
?>
