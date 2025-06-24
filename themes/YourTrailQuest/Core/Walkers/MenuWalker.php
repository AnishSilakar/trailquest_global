<?php
namespace Themes\YourTrailQuest\Core\Walkers;
class MenuWalker
{
	protected static $currentMenuItem;
	protected $menu;
	protected $options;
	protected $activeItems = [];

	public function __construct($menu)
	{
		$this->menu = $menu;
	}

	public function generate($options = [])
	{
		$this->options = $options ?? [];
		$items = json_decode($this->menu->items, true);
		$custom_class = (!empty($this->options)) ? $this->options['custom_class'] : null;
		if (!empty($items)) {
			echo "<ul class='menu__nav {$custom_class} -is-active'>";
			$this->generateTree($items);

			echo '</ul>';
			echo '    <ul class="right-menu"> <li>         <a href="https://api.whatsapp.com/send?1=pt_BR&amp;phone=09779818010366" target="_blank"><span>Need Help?  </span>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="rgba(18,202,85,1)" style="
    margin-left: 20px;
"><path d="M12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22C10.1671 22 8.44851 21.5064 6.97086 20.6447L2.00516 22L3.35712 17.0315C2.49494 15.5536 2.00098 13.8345 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2ZM8.59339 7.30019L8.39232 7.30833C8.26293 7.31742 8.13607 7.34902 8.02057 7.40811C7.93392 7.45244 7.85348 7.51651 7.72709 7.63586C7.60774 7.74855 7.53857 7.84697 7.46569 7.94186C7.09599 8.4232 6.89729 9.01405 6.90098 9.62098C6.90299 10.1116 7.03043 10.5884 7.23169 11.0336C7.63982 11.9364 8.31288 12.8908 9.20194 13.7759C9.4155 13.9885 9.62473 14.2034 9.85034 14.402C10.9538 15.3736 12.2688 16.0742 13.6907 16.4482C13.6907 16.4482 14.2507 16.5342 14.2589 16.5347C14.4444 16.5447 14.6296 16.5313 14.8153 16.5218C15.1066 16.5068 15.391 16.428 15.6484 16.2909C15.8139 16.2028 15.8922 16.159 16.0311 16.0714C16.0311 16.0714 16.0737 16.0426 16.1559 15.9814C16.2909 15.8808 16.3743 15.81 16.4866 15.6934C16.5694 15.6074 16.6406 15.5058 16.6956 15.3913C16.7738 15.2281 16.8525 14.9166 16.8838 14.6579C16.9077 14.4603 16.9005 14.3523 16.8979 14.2854C16.8936 14.1778 16.8047 14.0671 16.7073 14.0201L16.1258 13.7587C16.1258 13.7587 15.2563 13.3803 14.7245 13.1377C14.6691 13.1124 14.6085 13.1007 14.5476 13.097C14.4142 13.0888 14.2647 13.1236 14.1696 13.2238C14.1646 13.2218 14.0984 13.279 13.3749 14.1555C13.335 14.2032 13.2415 14.3069 13.0798 14.2972C13.0554 14.2955 13.0311 14.292 13.0074 14.2858C12.9419 14.2685 12.8781 14.2457 12.8157 14.2193C12.692 14.1668 12.6486 14.1469 12.5641 14.1105C11.9868 13.8583 11.457 13.5209 10.9887 13.108C10.8631 12.9974 10.7463 12.8783 10.6259 12.7616C10.2057 12.3543 9.86169 11.9211 9.60577 11.4938C9.5918 11.4705 9.57027 11.4368 9.54708 11.3991C9.50521 11.331 9.45903 11.25 9.44455 11.1944C9.40738 11.0473 9.50599 10.9291 9.50599 10.9291C9.50599 10.9291 9.74939 10.663 9.86248 10.5183C9.97128 10.379 10.0652 10.2428 10.125 10.1457C10.2428 9.95633 10.2801 9.76062 10.2182 9.60963C9.93764 8.92565 9.64818 8.24536 9.34986 7.56894C9.29098 7.43545 9.11585 7.33846 8.95659 7.32007C8.90265 7.31384 8.84875 7.30758 8.79459 7.30402C8.66053 7.29748 8.5262 7.29892 8.39232 7.30833L8.59339 7.30019Z"></path></svg>

				 <br /><span> +977-9818010366</span>
				 </a></li></ul>';
		}
	}

	public function generateTree($items = [], $depth = 0, $parentKey = '')
	{
		$desktopMenu = $this->options['desktop_menu'] ?? false;
		$mega_menu = $this->options['enable_mega_menu'] ?? false;
		foreach ($items as $k => $item) {
			$parentName = $item['name'];
			$class = e($item['class'] ?? '');
			$url = $item['url'] ?? '';
			$item['target'] = $item['target'] ?? '';
			if (!isset($item['item_model']))
				continue;
			if (class_exists($item['item_model'])) {
				$itemClass = $item['item_model'];
				$itemObj = $itemClass::find($item['id']);
				if (empty($itemObj)) {
					continue;
				}
				$url = $itemObj->getDetailUrl();
			}
			if ($this->checkCurrentMenu($item, $url)) {
				$class .= ' active';
				$this->activeItems[] = $parentKey;
			}

			if (!empty($item['children'])) {
				ob_start();
				$this->generateTree($item['children'], $depth + 1, $parentKey . '_' . $k);
				$html = ob_get_clean();
				if (in_array($parentKey . '_' . $k, $this->activeItems)) {
					$class .= ' active ';
				}
			}
			$class .= !empty($item['children']) ? ' menu-item-has-children' : null;
			$class .= ($depth == 0 && !empty($item['mega_menu']) && $mega_menu) ? ' -has-mega-menu' : null;
			$class .= ' depth-' . ($depth);
			printf('<li class="%s">', $class);
			$itemName = $item['name'];
			if (!empty($item['children'])) {
				$item['name'] = "<span class='mr-10'>{$item['name']}</span><i class='icon icon-chevron-sm-down'></i>";
			}
			printf('<a ' . ($desktopMenu ? 'data-barba' : '') . ' target="%s" href="%s" >%s</a>', e($item['target']), e($url), clean($item['name']));
			if (!empty($item['children'])) {
				if ($depth == 0 && !empty($item['mega_menu']) && $mega_menu) {
					echo '<div class="mega mb-menu-none column-' . ($item['mega_columns'] ?? '') . ' ' . (!empty($item['mega_image_url']) ? '--has-mega-image' : '') . '">';
					echo '<ul class="subnav">';
					echo $html;
					echo "</ul>";
					if (!empty($item['mega_image_url'])) {
						echo '<div class="mega-image">';
						echo '<img src="' . $item['mega_image_url'] . '" alt="' . $itemName . '">';
						echo '</div>';
					}
					echo '</div>';

					echo '<ul class="subnav mega-mobile pc-menu-none">';
					if ($desktopMenu) {
						echo '<li class="subnav__backBtn js-nav-list-back">
                                <a href="#"><i class="icon icon-chevron-sm-down"></i> ' . $itemName . '</a>
                            </li>';
					}
					echo $html;
					echo "</ul>";
				} else {
					echo '<ul class="subnav">';
					if ($desktopMenu) {
						echo '<li class="subnav__backBtn js-nav-list-back">
                                <a href="#"><i class="icon icon-chevron-sm-down"></i> ' . $itemName . '</a>
                            </li>';
					}
					echo $html;
					echo "</ul>";
				}
			}
			echo '</li>';
		}
	}

	protected function checkCurrentMenu($item, $url = '')
	{

		if (trim($url, '/') == request()->path()) {
			return true;
		}
		if (!static::$currentMenuItem)
			return false;
		if (empty($item['item_model']))
			return false;
		if (is_string(static::$currentMenuItem) and ($url == static::$currentMenuItem or $url == url(static::$currentMenuItem))) {
			return true;
		}
		if (is_object(static::$currentMenuItem) and get_class(static::$currentMenuItem) == $item['item_model'] && static::$currentMenuItem->id == $item['id']) {
			return true;
		}
		return false;
	}

	public static function setCurrentMenuItem($item)
	{
		static::$currentMenuItem = $item;
	}

	public static function getActiveMenu()
	{
		return static::$currentMenuItem;
	}
}
