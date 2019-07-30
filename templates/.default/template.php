<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<? if (!empty($arResult)) : ?>

	<div class="select-plate">

		<? if (
			!empty($arResult['MONTH']) &&
			!empty($arResult['MONTH_LINK'])
		) : ?>
			<div class="select">

				<div class="select-head js-select-trigger">
					<div class="select-head__title">
						<?= (!empty($_GET['month'])) ? base64_decode($_GET['month']) : Loc::getMessage('FLXMD_FILTER_DATE_ALL_YEAR'); ?>
					</div>
					<div class="select-head__item">
						<svg class="icon bottom-arrow-small">
							<use xlink:href="#bottom-arrow-small"></use>
						</svg>
					</div>
				</div>

				<div class="select-body">
					<div class="select-body__content">
						<div class="select-list">

							<? if (!empty($_GET['month'])) : ?>
								<div class="radio-option">
									<a href="<?= (!empty($arResult['ALL_MONTH_LINK'])) ? '?'.http_build_query($arResult['ALL_MONTH_LINK']) : $arResult['CUR_PAGE']; ?>" class="radio-option__caption">
										<?= Loc::getMessage('FLXMD_FILTER_DATE_ALL_YEAR'); ?>
									</a>
								</div>
							<? endif; ?>

							<? foreach ($arResult['MONTH'] as $key => $value) : ?>

								<div class="radio-option">
									<a href="<?= ($arResult['MONTH_LINK'][$value]) ? '?'.http_build_query( $arResult['MONTH_LINK'][$value] ) : ''; ?>" class="radio-option__caption" data-val="<?=$value;?>">
										<?=$value;?>
									</a>
								</div>

							<? endforeach; ?>

						</div>
					</div>
				</div>

			</div>
		<? endif; ?>

		<? if (
			!empty($arResult['YEAR']) &&
			!empty($arResult['YEAR_LINK'])
		) : ?>
			<div class="select">

				<div class="select-head js-select-trigger">
					<div class="select-head__title">
						<?= (!empty($_GET['year'])) ? base64_decode($_GET['year']) : Loc::getMessage('FLXMD_FILTER_DATE_ALL_YEARS'); ?>
					</div>
					<div class="select-head__item">
						<svg class="icon bottom-arrow-small">
							<use xlink:href="#bottom-arrow-small"></use>
						</svg>
					</div>
				</div>

				<div class="select-body">
					<div class="select-body__content">
						<div class="select-list">

							<? if (!empty($_GET['year'])) : ?>
								<div class="radio-option">
									<a href="<?= (!empty($arResult['ALL_YEAR_LINK'])) ? '?'.http_build_query($arResult['ALL_YEAR_LINK']) : $arResult['CUR_PAGE']; ?>" class="radio-option__caption">
										<?= Loc::getMessage('FLXMD_FILTER_DATE_ALL_YEARS'); ?>
									</a>
								</div>
							<? endif; ?>

							<? foreach ($arResult['YEAR'] as $key => $value) : ?>

								<div class="radio-option">
									<a href="<?= ($arResult['YEAR_LINK'][$value]) ? '?'.http_build_query( $arResult['YEAR_LINK'][$value] ) : ''; ?>" class="radio-option__caption" data-val="<?=$value;?>">
										<?=$value;?>
									</a>
								</div>

							<? endforeach; ?>

						</div>
					</div>
				</div>

			</div>
		<? endif; ?>

	</div>

<? endif; ?>
