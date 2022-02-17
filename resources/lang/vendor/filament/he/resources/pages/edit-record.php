<?php

return [

    'title' => 'ערוך :label',

    'breadcrumb' => 'ערוך',

    'actions' => [

        'delete' => [

            'label' => 'מחק',

            'modal' => [

                'heading' => 'מחק :label',

                'subheading' => 'האם אתה בטוח שברצונך למחוק?',

                'buttons' => [

                    'delete' => [
                        'label' => 'מחק',
                    ],

                ],

            ],

            'messages' => [
                'deleted' => 'נמחק',
            ],

        ],

        'view' => [
            'label' => 'תצוגה',
        ],

    ],

    'form' => [

        'actions' => [

            'cancel' => [
                'label' => 'ביטול',
            ],

            'save' => [
                'label' => 'שמור',
            ],

        ],

    ],

    'messages' => [
        'saved' => 'נשמר',
    ],

];
