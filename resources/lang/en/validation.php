<?php

return [
    'custom_edit' => [
        'name' => [
            'required' => 'The name field is required.',
        ],
        'username' => [
            'required' => 'The username field is required.',
            'unique' => 'The username has already been taken.',
        ],
        'email' => [
            'email' => 'The email must be a valid email address.',
            'unique' => 'The email has already been taken.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'min' => 'The password must be at least 6 characters.',
        ],
        'status' => [
            'required' => 'The status field is required.',
        ],
        'current_password' => [
            'required' => 'The current password field is required.',
            'invalid' => 'The current password does not match.',
        ],
        'password' => [
            'required' => 'The new password field is required.',
            'min' => 'The new password must be at least 6 characters.',
            'confirmed' => 'The new password confirmation does not match.',
        ],
    ],


    'name.required' => 'The name field is required.',
    'code.required' => 'The code field is required.',
    'code.unique' => 'The code has already been taken.',

    //Status
    'status_name.required' => 'The status name field is required',
    'status_name.unique' => 'The status name has already been taken',
    'status_status.required' => 'The status field is required',
    'status_status.boolean' => 'The status field must be true or false',

    //Category
    'category_name.required' => 'The category name field is required',
    'category_name.unique' => 'The category name has already been taken',
    'category_parent_id.exists' => 'The selected parent category does not exist',
    'category_parent_id.not_in' => 'A category cannot be its own parent',
    'category_status.required' => 'The category status field is required',
    'category_status.in' => 'The selected category status is invalid',

    //Department
    'department_name.required' => 'The department name field is required',
    'department_name.unique' => 'The department name has already been taken',

    //Defects
    'defect_category_id.required' => 'The category field is required',
    'defect_status_id.required' => 'The status field is required',
    'defect_occurred_at.required' => 'The occurred at field is required',
    'defect_status.in' => 'The selected status is invalid',
    'defect_images.image' => 'Each file must be an image',
    'defect_images.max' => 'Each image must not exceed the maximum allowed size',


    //Users
    'custom_edit.name.required' => 'The name field is required',
    'custom_edit.username.required' => 'The username field is required',
    'custom_edit.username.unique' => 'The username has already been taken',
    'custom_edit.email.email' => 'The email must be a valid email address',
    'custom_edit.email.unique' => 'The email has already been taken',
    'custom_edit.password.required' => 'The password field is required',
    'custom_edit.password.min' => 'The password must be at least :min characters',
    'custom_edit.role_id.required' => 'The role field is required',
    'custom_edit.department_id.required' => 'The department field is required',




];