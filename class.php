<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Main\Data\Cache,
	Bitrix\Main\Application;

class FlxMDFilterInBlog extends CBitrixComponent
{

	public function executeComponent()
	{

		if ( CModule::IncludeModule("iblock") ) {
			if ( empty($this->arParams['IBLOCK_ID']) ) {
				ShowError( Loc::getMessage('FLXMD_FILTER_DATE_NOT_PARAMS') );
				return;
			}
			$this->controller();
		} else {
			ShowError( Loc::getMessage('FLXMD_FILTER_DATE_MODULE_NOT_FOUND') );
			return;
		}

	}

	public function controller()
	{
		$this->getFilterParam();
		$this->setArResult();
		$this->setDefaultArResult();

		$this->IncludeComponentTemplate();
	}

	protected function getFilterParam()
	{
		$cache = Cache::createInstance();

		$sCacheID = "filter_blog_".serialize($this->arParams['BLOCK_ID']);

		if ($cache->initCache(86400, $sCacheID)) {

			$this->arResult = $cache->getVars();

		} elseif ($cache->startDataCache()) {

			$dbItemsMonthResult = CIBlockElement::GetList(
				array(
					'propertysort_MONTH' => 'ASC'
				),
				array(
					'ACTIVE' => 'Y',
					'IBLOCK_ID' => $this->arParams['IBLOCK_ID']
				),
				false,
				array(),
				array(
					'ID',
					'IBLOCK_ID',
					'PROPERTY_MONTH'
				)
			);

			$arMonth = array();

			while ( $dbListMonthItems = $dbItemsMonthResult->Fetch() ) {
				if ($dbListMonthItems['PROPERTY_MONTH_VALUE']) {
					$arMonth[] = $dbListMonthItems['PROPERTY_MONTH_VALUE'];
				}
			}

			$dbItemsYearResult = CIBlockElement::GetList(
				array(
					'propertysort_YEAR' => 'ASC'
				),
				array(
					'ACTIVE' => 'Y',
					'IBLOCK_ID' => $this->arParams['IBLOCK_ID']
				),
				false,
				array(),
				array(
					'ID',
					'IBLOCK_ID',
					'PROPERTY_YEAR'
				)
			);

			$arYear = array();

			while ( $dbListYearItems = $dbItemsYearResult->Fetch() ) {
				if ($dbListYearItems['PROPERTY_YEAR_VALUE']) {
					$arYear[] = $dbListYearItems['PROPERTY_YEAR_VALUE'];
				}
			}

			$this->arResult['MONTH'] = array_unique($arMonth);
			$this->arResult['YEAR'] = array_unique($arYear);

			$cache->endDataCache($this->arResult);
		}

	}

	protected function setArResult() {

		global $APPLICATION;
		$this->arResult['CUR_PAGE'] = $APPLICATION->GetCurPage();

		$this->request = Application::getInstance()->getContext()->getRequest();

		if ($this->arResult['MONTH']) {

			$this->arResult['MONTH_LINK'] = array();

			foreach ($this->arResult['MONTH'] as $key => $value) {

				$this->arResult['MONTH_LINK'][$value] = array(
					'month' => base64_encode($value)
				);

				if ($this->request->get('year')) {
					$this->arResult['MONTH_LINK'][$value]['year'] = htmlspecialchars( $this->request->get('year') );
				}

			}

		}

		if ($this->arResult['YEAR']) {

			$this->arResult['YEAR_LINK'] = array();

			foreach ($this->arResult['YEAR'] as $key => $value) {

				$this->arResult['YEAR_LINK'][$value] = array(
					'year' => base64_encode($value)
				);

				if ($this->request->get('month')) {
					$this->arResult['YEAR_LINK'][$value]['month'] = htmlspecialchars( $this->request->get('month') );
				}

			}

		}

	}

	protected function setDefaultArResult() {

		if (!empty(htmlspecialchars( $this->request->get('year') ))) {
			$this->arResult['ALL_MONTH_LINK']['year'] = htmlspecialchars( $this->request->get('year') );
		}
		if (!empty(htmlspecialchars( $this->request->get('month') ))) {
			$this->arResult['ALL_YEAR_LINK']['month'] = htmlspecialchars( $this->request->get('month') );
		}

	}

}
