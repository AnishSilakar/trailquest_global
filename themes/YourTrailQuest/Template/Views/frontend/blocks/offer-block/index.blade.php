@switch($style ?? '')
    @case('style2') @include("Template::frontend.blocks.offer-block.style2") @break
    @case('style3') @include("Template::frontend.blocks.offer-block.style2") @break
    @default @include("Template::frontend.blocks.offer-block.style1")
@endswitch
