<?php
/*
Plugin Name: CMB2 Field Type: Visual Style Editor
Plugin URI: https://github.com/rubengc/cmb2-field-visual-style-editor
GitHub Plugin URI: https://github.com/rubengc/cmb2-field-visual-style-editor
Description: CMB2 field type to setup style from small set of controls.
Version: 1.0.0
Author: Ruben Garcia
Author URI: http://rubengc.com/
License: GPLv2+
*/


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'CMB2_Field_Visual_Style_Editor' ) ) {
    /**
     * Class CMB2_Field_Position
     */
    class CMB2_Field_Visual_Style_Editor {

        /**
         * Current version number
         */
        const VERSION = '1.0.0';

        /**
         * Initialize the plugin by hooking into CMB2
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ) );
            add_action( 'cmb2_render_visual_style_editor', array( $this, 'render' ), 10, 5 );
            add_action( 'cmb2_sanitize_visual_style_editor', array( $this, 'sanitize' ), 10, 4 );
        }

        /**
         * Render field
         */
        public function render( $field, $value, $object_id, $object_type, $field_type ) {
            $show_margin = ( ! $field->args( 'hide_margin' ) );
            $show_border = ( ! $field->args( 'hide_border' ) );
            $show_padding = ( ! $field->args( 'hide_padding' ) );
            $show_text_options = ( ! $field->args( 'hide_text_options' ) );
            $show_background_options = ( ! $field->args( 'hide_background_options' ) );
            $show_border_options = ( ! $field->args( 'hide_border_options' ) );

            ?>
            <div class="cmb2-visual-style-editor">

                <?php if( $show_margin ) : ?>
                    <div class="cmb2-visual-style-editor-container cmb2-visual-style-editor-<?php echo $this->get_content_wrap_class( $value, 'margin' ); ?> cmb2-visual-style-editor-margin">
                        <label><?php _e( 'Margin', 'cmb2' ); ?></label>
                        <?php $this->content_wrap_fields( $field_type, $value, 'margin' ); ?>
                <?php endif; ?>

                    <?php if( $show_border ) : ?>
                        <div class="cmb2-visual-style-editor-container cmb2-visual-style-editor-<?php echo $this->get_content_wrap_class( $value, 'border' ); ?> cmb2-visual-style-editor-border">
                            <label><?php _e( 'Border', 'cmb2' ); ?></label>
                            <?php $this->content_wrap_fields( $field_type, $value, 'border' ); ?>
                    <?php endif; ?>

                        <?php if( $show_padding ) : ?>
                            <div class="cmb2-visual-style-editor-container cmb2-visual-style-editor-<?php echo $this->get_content_wrap_class( $value, 'padding' ); ?> cmb2-visual-style-editor-padding">
                                <label><?php _e( 'Padding', 'cmb2' ); ?></label>
                                <?php $this->content_wrap_fields( $field_type, $value, 'padding' ); ?>
                        <?php endif; ?>

                            <div class="cmb2-visual-style-editor-placeholder">&lt;/&gt;</div><!-- /content -->

                        <?php if( $show_padding ) : ?>
                            </div><!-- /padding -->
                        <?php endif; ?>

                    <?php if( $show_border ) : ?>
                        </div><!-- /border -->
                    <?php endif; ?>

            <?php if( $show_margin ) : ?>
                </div><!-- /margin -->
            <?php endif; ?>

                <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-switch-all">
                    <button type="button" class="button button-secondary"><?php _e( 'Toggle all', 'cmb2' ); ?></button>
                </div>
            </div>

            <div class="cmb2-visual-style-editor-extra-options">
                <?php if( $show_text_options ) : ?>
                    <div class="cmb2-visual-style-editor-text-options">
                        <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-text-color">
                            <label for="<?php echo $field_type->_id(); ?>_text_color"><?php _e( 'Text color:', 'cmb2' ); ?></label>
                            <?php echo $field_type->input( array(
                                'name'    => $field_type->_name() . '[text_color]',
                                'desc'    => '',
                                'id'      => $field_type->_id() . '_text_color',
                                'class' => 'cmb2-content-wrap-input cmb2-visual-style-editor-color-picker',
                                'value' => ( ( isset( $value['text_color'] ) ) ? $value['text_color'] : '' ),
                            ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $show_background_options ) : ?>
                    <div class="cmb2-visual-style-editor-background-options">
                        <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-background-color">
                            <label for="<?php echo $field_type->_id(); ?>_background_color"><?php _e( 'Background color:', 'cmb2' ); ?></label>
                            <?php echo $field_type->input( array(
                                'name'    => $field_type->_name() . '[background_color]',
                                'desc'    => '',
                                'id'      => $field_type->_id() . '_background_color',
                                'class' => 'cmb2-content-wrap-input cmb2-visual-style-editor-color-picker',
                                'value' => ( ( isset( $value['background_color'] ) ) ? $value['background_color'] : '' ),
                            ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $show_border_options ) : ?>
                    <div class="cmb2-visual-style-editor-border-options">
                        <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-border-color">
                            <label for="<?php echo $field_type->_id(); ?>_border_color"><?php _e( 'Border color:', 'cmb2' ); ?></label>
                            <?php echo $field_type->input( array(
                                'name'    => $field_type->_name() . '[border_color]',
                                'desc'    => '',
                                'id'      => $field_type->_id() . '_border_color',
                                'class' => 'cmb2-content-wrap-input cmb2-visual-style-editor-color-picker',
                                'value' => ( ( isset( $value['border_color'] ) ) ? $value['border_color'] : '' ),
                            ) ); ?>
                        </div>

                        <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-border-style">
                            <label for="<?php echo $field_type->_id(); ?>_border_style"><?php _e( 'Border style:', 'cmb2' ); ?></label>
                            <?php
                            $border_style_options = array(
                                '' => 'Theme defaults',
                                'solid' => 'Solid',
                                'dotted' => 'Dotted',
                                'dashed' => 'Dashed',
                                'none' => 'None',
                                'hidden' => 'Hidden',
                                'double' => 'Double',
                                'groove' => 'Groove',
                                'ridge' => 'Ridge',
                                'inset' => 'Inset',
                                'outset' => 'Outset',
                                'initial' => 'Initial',
                                'inherit' => 'Inherit',
                            );

                            echo $field_type->select( array(
                                'name'    => $field_type->_name() . '[border_style]',
                                'desc'    => '',
                                'id'      => $field_type->_id() . '_border_style',
                                'class' => 'cmb2-content-wrap-select',
                                'options' => $this->build_options_string( $field_type, $border_style_options, ( ( isset( $value['border_style'] ) ) ? $value['border_style'] : '' ) ),
                            ) );
                            ?>
                        </div>

                        <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-border-radius">
                            <label for="<?php echo $field_type->_id(); ?>_border_radius"><?php _e( 'Border radius:', 'cmb2' ); ?></label>
                            <?php echo $field_type->input( array(
                                'name'    => $field_type->_name() . '[border_radius]',
                                'desc'    => '',
                                'id'      => $field_type->_id() . '_border_radius',
                                'class' => 'cmb2-text-small cmb2-content-wrap-input',
                                'value' => ( ( isset( $value['border_radius'] ) ) ? $value['border_radius'] : '' ),
                            ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            $field_type->_desc( true, true );
        }

        private function content_wrap_fields( $field_type, $value, $group ) {
            ?>
            <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-<?php echo $group; ?>-all cmb2-visual-style-editor-field-all">
                <?php echo $field_type->input( array(
                    'name'    => $field_type->_name() . "[{$group}_all]",
                    'desc'    => '',
                    'id'      => $field_type->_id() . "_{$group}_all",
                    'class' => 'cmb2-text-small cmb2-content-wrap-input',
                    'placeholder' => '-',
                    'value' => ( ( isset( $value[$group . '_all'] ) ) ? $value[$group . '_all'] : '' ),
                ) ); ?>
            </div>

            <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-<?php echo $group; ?>-top cmb2-visual-style-editor-field-top">
                <?php echo $field_type->input( array(
                    'name'    => $field_type->_name() . "[{$group}_top]",
                    'desc'    => '',
                    'id'      => $field_type->_id() . "_{$group}_top",
                    'class' => 'cmb2-text-small cmb2-content-wrap-input',
                    'placeholder' => '-',
                    'value' => ( ( isset( $value[$group . '_top'] ) ) ? $value[$group . '_top'] : '' ),
                ) ); ?>
            </div>

            <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-<?php echo $group; ?>-right cmb2-visual-style-editor-field-right">
                <?php echo $field_type->input( array(
                    'name'    => $field_type->_name() . "[{$group}_right]",
                    'desc'    => '',
                    'id'      => $field_type->_id() . "_{$group}_right",
                    'class' => 'cmb2-text-small cmb2-content-wrap-input',
                    'placeholder' => '-',
                    'value' => ( ( isset( $value[$group . '_right'] ) ) ? $value[$group . '_right'] : '' ),
                ) ); ?>
            </div>

            <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-<?php echo $group; ?>-bottom cmb2-visual-style-editor-field-bottom">
                <?php echo $field_type->input( array(
                    'name'    => $field_type->_name() . "[{$group}_bottom]",
                    'desc'    => '',
                    'id'      => $field_type->_id() . "_{$group}_bottom",
                    'class' => 'cmb2-text-small cmb2-content-wrap-input',
                    'placeholder' => '-',
                    'value' => ( ( isset( $value[$group . '_bottom'] ) ) ? $value[$group . '_bottom'] : '' ),
                ) ); ?>
            </div>

            <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-<?php echo $group; ?>-left cmb2-visual-style-editor-field-left">
                <?php echo $field_type->input( array(
                    'name'    => $field_type->_name() . "[{$group}_left]",
                    'desc'    => '',
                    'id'      => $field_type->_id() . "_{$group}_left",
                    'class' => 'cmb2-text-small cmb2-content-wrap-input',
                    'placeholder' => '-',
                    'value' => ( ( isset( $value[$group . '_left'] ) ) ? $value[$group . '_left'] : '' ),
                ) ); ?>
            </div>

            <div class="cmb2-visual-style-editor-field cmb2-visual-style-editor-field-switch">
                <button type="button" class="button button-secondary"><i class="dashicons"></i></button>
            </div>
            <?php
        }

        private function get_content_wrap_class( $value, $group ) {
            $initial_content_wrap = 'multiple';

            /*if( ( isset( $value[$group . '_top'] ) && ! empty( $value[$group . '_top'] ) )
                || ( isset( $value[$group . '_right'] ) && ! empty( $value[$group . '_right'] ) )
                || ( isset( $value[$group . '_bottom'] ) && ! empty( $value[$group . '_bottom'] ) )
                || ( isset( $value[$group . '_left'] ) && ! empty( $value[$group . '_left'] ) ) ) {
                $initial_content_wrap = 'multiple';
            }*/

            if( isset( $value[$group . '_all'] ) && ! empty( $value[$group . '_all'] ) ) {
                $initial_content_wrap = 'single';
            }

            return $initial_content_wrap;
        }

        private function build_options_string( $field_type, $options, $value ) {
            $options_string = '';

            foreach( $options as $val => $label) {
                $options_string .= '<option value="' . $val . '" ' . selected( $value, $val, false ) . '>' . $label . '</option>';
            }

            return $options_string;
        }

        /**
         * Optionally save the latitude/longitude values into two custom fields
         */
        public function sanitize( $override_value, $value, $object_id, $field_args ) {
            $fid = $field_args['id'];

            if( $field_args['render_row_cb'][0]->data_to_save[$fid] ) {
                $value = $field_args['render_row_cb'][0]->data_to_save[$fid];
            } else {
                $value = false;
            }

            return $value;
        }

        /**
         * Enqueue scripts and styles
         */
        public function setup_admin_scripts() {
            wp_register_script( 'cmb-visual-style-editor', plugins_url( 'js/visual-style-editor.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), self::VERSION, true );

            wp_enqueue_script( 'cmb-visual-style-editor' );

            wp_register_style( 'cmb-visual-style-editor', plugins_url( 'css/visual-style-editor.css', __FILE__ ), array(), self::VERSION );

            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( 'cmb-visual-style-editor' );

        }

    }

    $cmb2_field_visual_style_editor = new CMB2_Field_Visual_Style_Editor();
}
