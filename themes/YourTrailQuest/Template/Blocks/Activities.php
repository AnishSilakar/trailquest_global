<?php
namespace Themes\YourTrailQuest\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;

class Activities extends BaseBlock
{

    public function getOptions()
    {
        return [
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'textArea',
                    'label'     => __('Description')
                ],
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'    => 'image',
                            'type'  => 'uploader',
                            'label' => __('Image'),
                        ],
                        [
                            'id'        => 'link_title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title Link More')
                        ],
                        [
                            'id'        => 'link_more',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Link More')
                        ],
                    ]
                ],
            ],
            'category'=>__("Other Block")
        ];
    }

    public function getName()
    {
        return __('Activities');
    }

    public function content($model = [])
    {
        return $this->view('Template::frontend.blocks.activities.index', $model);
    }

}
