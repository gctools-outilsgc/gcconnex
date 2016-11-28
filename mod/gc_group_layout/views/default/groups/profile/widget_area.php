<?php

echo '<div id="customWidgets">';

                $num_columns = elgg_extract('num_columns', $vars, 2);
                $show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
                $exact_match = elgg_extract('exact_match', $vars, false);
                $show_access = elgg_extract('show_access', $vars, true);

                
                $owner = elgg_get_page_owner_entity();

                elgg_push_context('groups');
                $widget_types = elgg_get_widget_types();

                
                $context = elgg_get_context();
                

                $widgets = elgg_get_widgets($owner->guid, $context);

                if (elgg_can_edit_widget_layout($context)) {

                    $params = array(
                        'widgets' => $widgets,
                        'context' => $context,
                        'exact_match' => $exact_match,
                        'show_access' => $show_access,
                    );
                    
                    echo elgg_view('page/layouts/widgets/add_panel', $params);
                    
                }

                if (elgg_can_edit_widget_layout($context)) {
                    if ($show_add_widgets) {
                        echo elgg_view('page/layouts/widgets/add_button');
                    }

                    $params = array(
                        'widgets' => $widgets,
                        'context' => $context,
                        'exact_match' => $exact_match,
                    );
                    echo elgg_view('page/layouts/widgets/add_panel', $params);
                }

                $widget_class = "elgg-col-1of{$num_columns}";

                for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
                    if (isset($widgets[$column_index])) {
                        $column_widgets = $widgets[$column_index];
                    } else {
                        $column_widgets = array();
                    }
                    
                    echo "<div class=\"$widget_class elgg-widgets col-sm-6 col-xs-12 widget-area-col\" id=\"elgg-widget-col-$column_index\">";
                    
                    if (sizeof($column_widgets) > 0) {
                        foreach ($column_widgets as $widget) {
                            if (array_key_exists($widget->handler, $widget_types)) {
                                echo elgg_view_entity($widget, array('show_access' => $show_access));
                            }
                            
                        }
                    }
                    echo '</div>';
                }
            echo '</div>'; 

            

elgg_pop_context();