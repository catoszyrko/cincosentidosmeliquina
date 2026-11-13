<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/inc/bootstrap.php';

header('X-Robots-Tag: noindex, nofollow');
require_admin();

try {
    $leads = db_leads_all();
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'No se pudo leer la base: ' . $e->getMessage();
    exit;
}

function xls_text(?string $value): string
{
    $value = preg_replace('/[^\P{C}\t\n\r]/u', '', (string) $value) ?? '';
    return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function xls_cell(?string $value, string $type = 'String', string $style = ''): string
{
    $value = (string) $value;
    if ($value === '') {
        return '<Cell/>';
    }
    $styleAttr = $style !== '' ? ' ss:StyleID="' . $style . '"' : '';
    return '<Cell' . $styleAttr . '><Data ss:Type="' . $type . '">' . xls_text($value) . '</Data></Cell>';
}

$columns = [
    ['Fecha', 120],
    ['Nombre', 140],
    ['Contacto', 160],
    ['Personas', 70],
    ['Entrada', 85],
    ['Salida', 85],
    ['Habitación', 90],
    ['Mensaje', 320],
    ['Página', 150],
];

$filename = 'consultas-' . date('Y-m-d') . '.xls';
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-store');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Top"/>
   <Font ss:FontName="Calibri" ss:Size="11"/>
  </Style>
  <Style ss:ID="head">
   <Font ss:FontName="Calibri" ss:Size="11" ss:Bold="1" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#1F6B5A" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="datetime"><NumberFormat ss:Format="dd/mm/yyyy hh:mm"/></Style>
  <Style ss:ID="date"><NumberFormat ss:Format="dd/mm/yyyy"/></Style>
  <Style ss:ID="wrap"><Alignment ss:Vertical="Top" ss:WrapText="1"/></Style>
 </Styles>
 <Worksheet ss:Name="Consultas">
  <Table>
<?php foreach ($columns as [, $width]): ?>
   <Column ss:Width="<?= (int) $width ?>"/>
<?php endforeach; ?>
   <Row>
<?php foreach ($columns as [$label]): ?>
    <?= xls_cell($label, 'String', 'head') ?>

<?php endforeach; ?>
   </Row>
<?php foreach ($leads as $row):
    $created = strtotime((string) $row['created_at']);
    ?>
   <Row>
    <?= xls_cell($created ? date('Y-m-d\TH:i:s', $created) : '', 'DateTime', 'datetime') ?>
    <?= xls_cell((string) $row['nombre']) ?>
    <?= xls_cell((string) ($row['contacto'] ?? '')) ?>
    <?= xls_cell($row['huespedes'] !== null ? (string) $row['huespedes'] : '', 'Number') ?>
    <?= xls_cell(!empty($row['checkin']) ? $row['checkin'] . 'T00:00:00' : '', 'DateTime', 'date') ?>
    <?= xls_cell(!empty($row['checkout']) ? $row['checkout'] . 'T00:00:00' : '', 'DateTime', 'date') ?>
    <?= xls_cell((string) ($row['casa'] ?: 'A definir')) ?>
    <?= xls_cell((string) ($row['mensaje'] ?? ''), 'String', 'wrap') ?>
    <?= xls_cell((string) ($row['pagina'] ?? '')) ?>
   </Row>
<?php endforeach; ?>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <FreezePanes/>
   <FrozenNoSplit/>
   <SplitHorizontal>1</SplitHorizontal>
   <TopRowBottomPane>1</TopRowBottomPane>
   <ActivePane>2</ActivePane>
  </WorksheetOptions>
  <AutoFilter x:Range="R1C1:R<?= count($leads) + 1 ?>C<?= count($columns) ?>" xmlns="urn:schemas-microsoft-com:office:excel"/>
 </Worksheet>
</Workbook>
