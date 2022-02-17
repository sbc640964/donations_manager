<?php

return [

    'fields' => [

        'search_query' => [
            'label' => 'חיפוש',
            'placeholder' => 'חפש',
        ],

    ],

    'pagination' => [

        'label' => 'ניוט דפים',

        'overview' => 'מציג מ :first עד :last מתוך :total תוצאות',

        'fields' => [

            'records_per_page' => [
                'label' => 'לעמוד',
            ],

        ],

        'buttons' => [

            'go_to_page' => [
                'label' => 'לך אל עמוד :page',
            ],

            'next' => [
                'label' => 'הבא',
            ],

            'previous' => [
                'label' => 'הקודם',
            ],

        ],

    ],

    'buttons' => [

        'filter' => [
            'label' => 'סנן',
        ],

        'open_actions' => [
            'label' => 'פתח פעולות',
        ],

    ],

    'actions' => [

        'modal' => [

            'requires_confirmation_subheading' => 'האם אתה בטוח שתרצה לעשות זאת?',

            'buttons' => [

                'cancel' => [
                    'label' => 'ביטול',
                ],

                'confirm' => [
                    'label' => 'אישור',
                ],

                'submit' => [
                    'label' => 'שלח',
                ],

            ],

        ],

    ],

    'empty' => [
        'heading' => 'לא נמצאו שורות',
    ],

    'filters' => [

        'buttons' => [

            'reset' => [
                'label' => 'אפס מסננים',
            ],

        ],

        'multi_select' => [
            'placeholder' => 'הכל',
        ],

        'select' => [
            'placeholder' => 'הכל',
        ],

    ],

    'selection_indicator' => [

        'selected_count' => 'שורה אחת נבחרה.|נבחרו :count שורות.',

        'buttons' => [

            'select_all' => [
                'label' => 'בחר את כל :count',
            ],

            'deselect_all' => [
                'label' => 'הסר בחירה מהכל',
            ],

        ],

    ],

];
