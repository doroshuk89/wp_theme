<!-- Block menu -->
            <?php wp_nav_menu(array(
                                        'theme_location'  => 'main_menu',     // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции
                                        'menu'            => '',              // (string) Название выводимого меню (указывается в админке при создании меню, приоритетнее чем указанное местоположение theme_location - если указано, то параметр theme_location игнорируется)
                                        'container'       => 'div',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
                                        'container_class' => 'navbar-collapse collapse',              // (string) class контейнера (div тега)
                                        'container_id'    => 'navbar',        // (string) id контейнера (div тега)
                                        'menu_class'      => 'nav navbar-nav navbar-right',          // (string) class самого меню (ul тега)
                                        'menu_id'         => '',              // (string) id самого меню (ul тега)
                                        'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
                                        'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
                                        'before'          => '',              // (string) Текст перед <a> каждой ссылки
                                        'after'           => '',              // (string) Текст после </a> каждой ссылки
                                        'link_before'     => '<span>',              // (string) Текст перед анкором (текстом) ссылки
                                        'link_after'      => '</span>',              // (string) Текст после анкора (текста) ссылки
                                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                        'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
                                    )
                    );
            ?>                
        <!-- End Block Menu -->