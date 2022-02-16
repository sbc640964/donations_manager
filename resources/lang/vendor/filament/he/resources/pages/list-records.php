<?php

return [

    'breadcrumb' => 'רשימה',

    'actions' => [

        'create' => [

            'label' => ':label חדש',

            'modal' => [

                'heading' => 'צור :label',

                'actions' => [

                    'create' => [
                        'label' => 'צור',
                    ],

                    'create_and_create_another' => [
                        'label' => 'צור והחל אחד חדש',
                    ],

                ],

            ],

            'messages' => [
                'created' => 'נוצר בהצלחה',
            ],

        ],

    ],

    'table' => [

        'actions' => [

            'delete' => [

                'label' => 'מחיקה',

                'messages' => [
                    'deleted' => 'נמחק בהצלחה',
                ],

            ],

            'edit' => [

                'label' => 'ערוך',

                'modal' => [

                    'heading' => 'עריכת :label',

                    'actions' => [

                        'save' => [
                            'label' => 'שמור',
                        ],

                    ],

                ],

                'messages' => [
                    'saved' => 'נשמר בהצלחה',
                ],

            ],

            'view' => [
                'label' => 'תצוגה',
            ],

        ],

        'bulk_actions' => [

            'delete' => [

                'label' => 'מחק נבחרים',

                'messages' => [
                    'deleted' => 'נמחק בהצלחה',
                ],

            ],

        ],

    ],

];
