<?php

class Keyboards
{
    const STARTER = ['inline_keyboard'=>[
        [
            [
                'text'=>'Select location',
                'callback_data'=>'1'
            ],
            [
                'text'=>'Get weather',
                'callback_data'=>'2'
            ],
            [
                'text'=>'Set reminder',
                'callback_data'=>'3'
            ]
        ]
    ]];

    const LOCATIONS = ['inline_keyboard'=>[
        [
            [
                'text'=>'Bila Tserkva',
                'callback_data'=>'city_a'
            ],
            [
                'text'=>'Kyiv',
                'callback_data'=>'city_b'
            ]
        ]
    ]];

    const REMINDER = ['inline_keyboard'=>[
        [
            [
                'text'=>'Set time',
                'callback_data'=>'4'
            ],
            [
                'text'=>'Set interval',
                'callback_data'=>'5'
            ],
            [
                'text'=>'Set quantity',
                'callback_data'=>'6'
            ],
            [
                'text'=>'Delete all',
                'callback_data'=>'7'
            ],
            [
                'text'=>'RETURN',
                'callback_data'=>'8'
            ]
        ]
    ]];

    const REMINDER_INTERVAL = ['inline_keyboard'=>[
        [
            [
                'text'=>'Set minutes',
                'callback_data'=>'9'
            ],
            [
                'text'=>'Set hours',
                'callback_data'=>'10'
            ],
            [
                'text'=>'Set days',
                'callback_data'=>'11'
            ],
            [
                'text'=>'RETURN',
                'callback_data'=>'12'
            ]
        ]
    ]];
    const REMINDER_INTERVAL_MINUTES = ['inline_keyboard'=>[
        [
            [
                'text'=>'1',
                'callback_data'=>'min-1'
            ],
            [
                'text'=>'2',
                'callback_data'=>'min-2'
            ],
            [
                'text'=>'5',
                'callback_data'=>'min-5'
            ],
            [
                'text'=>'10',
                'callback_data'=>'min-10'
            ]
        ]
    ]];
    const REMINDER_INTERVAL_HOURS = ['inline_keyboard'=>[
        [
            [
                'text'=>'1',
                'callback_data'=>'hr-1'
            ],
            [
                'text'=>'2',
                'callback_data'=>'hr-2'
            ],
            [
                'text'=>'4',
                'callback_data'=>'hr-4'
            ],
            [
                'text'=>'8',
                'callback_data'=>'hr-8'
            ]
        ]
    ]];
    const REMINDER_INTERVAL_DAYS = ['inline_keyboard'=>[
        [
            [
                'text'=>'1',
                'callback_data'=>'d-1'
            ],
            [
                'text'=>'2',
                'callback_data'=>'d-2'
            ],
            [
                'text'=>'3',
                'callback_data'=>'d-3'
            ],
            [
                'text'=>'4',
                'callback_data'=>'d-4'
            ]
        ]
    ]];

    const REMINDER_INTERVAL_QUANT = ['inline_keyboard'=>[
        [
            [
                'text'=>'1',
                'callback_data'=>'q-1'
            ],
            [
                'text'=>'2',
                'callback_data'=>'q-2'
            ],
            [
                'text'=>'3',
                'callback_data'=>'q-3'
            ],
            [
                'text'=>'4',
                'callback_data'=>'q-4'
            ],
            [
                'text'=>'5',
                'callback_data'=>'q-5'
            ]
        ]
    ]];
}