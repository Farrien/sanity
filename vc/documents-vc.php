<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

//	//	03.09.2018//	Author: Farrien//	
#require_once $_SERVER['DOCUMENT_ROOT'] . '/outsource/tcpdf/tcpdf.php';
#require_once $_SERVER['DOCUMENT_ROOT'] . '/outsource/fpdi/fpdi.php';

use setasign\Fpdi\TcpdfFpdi;
function floorsArray($apartment, $floor__id, $section__id){
	$floorsMax = 24;
	$sectionMaxQuartiers = [
		1 => 13,
		2 => 8,
		3 => 9,
	];
	
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
	$url = $protocol . $_SERVER['SERVER_NAME'];
	$apartmentsInFloor = json_decode(file_get_contents($url . '/apartments/?request_type=1&param_sections=' . $section__id . '&param_floor=' . $floor__id), true);

	$ourLayout = 1;
	$currentLayoutNumber = 1;
	foreach ($apartmentsInFloor as $k=>$v) {
		if ($v['number'] == $apartment) {
			$ourLayout = $currentLayoutNumber;
		}
		$currentLayoutNumber++;
	}
	return $ourLayout;
}

if ($request->hasAugments()) {
	$augs = $request->augments();
	if ($augs->{0} == 'pdf') {
		$apartment = (int) $augs->{1};
		
		class PDF extends TcpdfFpdi {
			var $pdf;
			var $filename;
			var $page_count;

			public function __construct($filename) {
				parent::__construct();
				$this->filename = $filename;
			}

			public function Header() {
				if (is_null($this->pdf)) $this->setSourceFile($this->filename);
			}
		}
		
		if ($apartment) {
			$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
			$url = $protocol . $_SERVER['SERVER_NAME'];
			$file = json_decode(file_get_contents($url . '/apartments/?request_type=2&param_number=' . $apartment), true);
			
			if (count($file) < 1) {
				SN\Management::NewErr();
				SN\Management::ExplainLast('Document not found.');
				return false;
			};
			$section = $file['section'];
			$floor = $file['floor'];
			$area = $file['area'] . ' м<sup>2</sup>';
			$price =$file['price'] . ' руб.';
			$layout_type = floorsArray($apartment, $floor, $section);
			$layout_apartment_path = $_SERVER['DOCUMENT_ROOT'] . 'res/docs/apartments/layouts_apartment/' . $section . '_section_' . $layout_type . '.png';
			$layout_floor_path = $_SERVER['DOCUMENT_ROOT'] . 'res/docs/apartments/layouts_floor/layout_' . $section . '_' . $layout_type . '.png';

			$pdf__location = $_SERVER['DOCUMENT_ROOT'] . '/res/docs/apartments/templates/section-' . $section . '.pdf';
			$font__color = '#666A73';

			$pdf = new PDF($pdf__location);
			
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetTitle(SITE_NAME . ' | Квартира №' . $apartment);
			$pdf->SetSubject(SITE_NAME . ' | Квартира №' . $apartment);
			$pdf->SetAuthor(SITE_NAME);
			$pdf->SetFontSubsetting(false);
			$pdf->SetAutoPageBreak(false);

			$pdf->setFontSubsetting(true);
			$pdf->AddFont('ptsans', '', $_SERVER['DOCUMENT_ROOT'] . '/outsource/tcpdf_fonts/ptsans.php');
			$pdf->AddFont('ptsans', 'italic', $_SERVER['DOCUMENT_ROOT'] . '/outsource/tcpdf_fonts/ptsansi.php');
			$pdf->SetFont('ptsans', '', 12);
			
		
			$pdf->AddPage('L','A4');
			$pdf->useTemplate($pdf->importPage(1));
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 76/*Y*/, $apartment, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 95/*Y*/, $area, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 113/*Y*/, $floor, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 132/*Y*/, $section, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 151.5/*Y*/, $price, 0, null, null, null, '');
			$pdf->Image($layout_floor_path, 80, 60, '', 100, 'PNG', false, 'C', false, 300, false, false, false, 300, false, false, false);
		
			$pdf->AddPage('L','A4');
			$pdf->useTemplate($pdf->importPage(2));
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 76/*Y*/, $apartment, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 95/*Y*/, $area, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 113/*Y*/, $floor, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 132/*Y*/, $section, 0, null, null, null, '');
			$pdf->writeHTMLCell(0, 0, 47/*X*/, 151.5/*Y*/, $price, 0, null, null, null, '');
			$pdf->Image($layout_apartment_path, 80, 20, '', 180, 'PNG');
			
			
			$pdf->Output('apartment-' . $apartment.  '.pdf', 'I');
		}
		SN\Management::NewErr();
		SN\Management::ExplainLast('Requires an apartment\'s ID. Null given.');
		return false;
	}
}
return [false];