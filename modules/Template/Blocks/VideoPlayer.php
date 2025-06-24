<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class VideoPlayer extends BaseBlock
{

    public function getName()
    {
        return __('Video Player');
    }

    public function getOptions()
    {
        return [
            'settings' => [
                [
                    'id'     => 'style',
                    'type'   => 'radios',
                    'label'  => __('Style Background'),
                    'values' => [
                        [
                            'value' => 'style_1',
                            'name'  => __("Single"),
                        ],
                        [
                            'value' => 'style_2',
                            'name'  => __("Multiple "),
                        ],
                    ],
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title'),
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Discription'),
                ],
                [
                    'id'         => 'youtube',
                    'type'       => 'input',
                    'inputType'  => 'text',
                    'label'      => __('Youtube link'),
                    'conditions' => ['style' => ['style_1']],

                ],
                [
                    'id'        => 'videowidth',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Video Width'),
                    'conditions' => ['style' => ['style_1']],

                ],
                [
                    'id'        => 'videoheight',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Video Height'),
                    'conditions' => ['style' => ['style_1']],

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
                            'label'     => __('Title'),
                        ],
                        [
                            'id'         => 'youtube',
                            'type'       => 'input',
                            'inputType'  => 'text',
                            'label'      => __('Youtube link'),
                        ],
                    ],
                    'conditions' => ['style' => ['style_2']],
                ],
            ],
            'category' => __("Other Block"),
        ];
    }

    public function content($model = [])
    {
        $model['id'] = time();
        return $this->view('Template::frontend.blocks.video-player', $model);
    }

    public function contentAPI($model = [])
    {
        if (! empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return $model;
    }
}
