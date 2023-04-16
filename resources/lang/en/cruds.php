<?php
return [
    'welcome' => [
         'dashboard' => 'Dashboard',
         'domains' => 'Domains',
         'measures' => 'Controls',
         'controls' => 'Measurements',
         'action_plans' => "Action Plans",
         'next_controls' => 'Checks scheduled for the next 30 days',
         'control_status' => 'Measurement status',
         'control_planning' => 'Schedule measure',        
    ],
     'action' => [
         'index' => 'Action plans',
         'show' => 'Action Plan',
         'fields' => [
             'clause' => 'Clause',
             'name' => 'Name',
             'action' => 'Action plan',
             'plan_date' => 'Planning date',
             'next_date' => 'Review date',
             'note' => 'Score',
             'objective' => 'Objective',
             'observation' => 'Observation',
             'action_plan' => 'Action Plan',
         ],
     ],
    'attribute' => [
        'fields' => [
            'name' => 'Name',
            'values' => 'Values',
        ],
        'add' => 'Add attribute',
        'edit' => 'Edit attribute',
        'show' => 'Attribute',
        'index' => 'List of attributes',
        'choose' => 'Choose an attribute',
        'title' => 'Attribute'     
    ],
     'control' => [
         'description' => '',
         'fields' => [
             'action_plan' => 'Action Plan',
             'attributes' => 'Attributes',
             'choose_domain' => 'Choose domain',
             'choose_period' => 'Choose a period',
             'choose_attribute' => 'Choose an attribute',
             'domain' => 'Domain',
             'indicator' => 'Function',
             'measure' => 'Measure',
             'model' => 'Model',
             'name' => 'Name',
             'next' => 'Next',
             'note' => 'Note',
             'objective' => 'Objective',
             'observations' => 'Observations',
             'plan_date' => 'Planning date',
             'period' => 'Period',
             'periodicity' => 'Periodicity',
             'planned' => 'Planned',
             'realisation_date' => 'Realization date',
             'realized' => 'Realized',
             'evidence' => 'Evidence',
             'score' => 'Score',
             'status' => 'State',
             'status_done' => 'Done',
             'status_todo' => 'To do',
             'status_all' => 'All',
             'clause' => 'Clause',
             'input' => 'Input'
         ],
         'checklist' => 'Control sheet',
         'list' => 'List of controls',
         'edit' => 'Edit security check',
         'history' => 'Schedule',
         'make' => 'Make a check',
         'plan' => 'Schedule a check',
         'radar' => 'Security checks status',
         'title' => 'Measurements',
         'title_singular' => 'Measurement',
     ],
     'measure' => [
         'title' => 'Control',
         'fields' => [
             'domain' => 'Domain',
             'clause' => 'Clause',
             'name' => 'Name',
             'objective' => 'Description',
             'attributes' => 'Attributes',
             'model' => 'Model',
             'indicator' => 'Indicator',
             'action_plan' => 'Action Plan',
             'owner' => 'Responsible',
             'periodicity' => 'Periodicity',
             'input' => 'Input',
         ],
         'show' => 'Control',
         'index' => 'List of controls',
         'create' => 'Add control',
         'edit' => 'Edit a control',
         'plan' => 'Measurement planning'
     ],
     'domain' => [
         'fields' => [
             'name' => 'Name',
             'description' => 'Description',
         ],
         'add' => 'Add Domain',
         'edit' => 'Edit Domain',
         'show' => 'Domain',
         'index' => 'List of domains',
         'choose' => 'Choose domain',
         'title' => 'Domain'
     ],
     'document' => [
         'title' => 'Document',
         'description' => 'Description',
         'list' => 'List of documents',
         'index' => 'Documents',
         'fields' => [
             'name' => 'Name',
             'control' => 'Control',
             'size' => 'Size',
             'hash' => 'Hash',
         ],
         'model' => [
            'control' => 'Control sheet template',
            'report' => 'Steering report template',
         ],
         'count' => 'Number of documents',
         'total_size' => 'Total Size',
     ],
    'exports' => [
         'index' => 'Export data',
         'start' => 'Start',
         'end' => 'End',
         'report_title' => 'Report',
         'steering' => 'ISMS steering report',
         'data_export_title' => 'Data Export',
         'domains_export'=> 'Domains export',
         'measures_export' => 'Export of security measures',
         'controls_export' => 'Controls export',
     ],
     'login' => [
         'title' => 'Enter a password',
         'identification' => 'Identification',
         'connection' => 'Connection',
     ],
     'user' => [
         'index' => 'List of users',
         'edit' => 'Edit User',
         'add' => 'Add User',
         'fields' => [
             'login' => 'Login',
             'name' => 'Name',
             'title' => 'Title',
             'role' => 'Role',
             'password' => 'Password',
             'email' => 'email',
            'language' => 'Language',
         ],
         'roles' => [
             'admin' => 'Administrator',
             'user' => 'User',
             'auditor' => 'Auditor'
         ],
     ],
];
