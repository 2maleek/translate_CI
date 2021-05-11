<html>
<head>
<style type="text/css" media="print">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000; page-break-inside: avoid;}
	td { padding: 7px 5px; font-size: 10px}
	th {
		font-family:Arial;
		color:black;
		font-size: 11px;
		background-color:lightgrey;
	}
	thead {
		display:table-header-group;
	}
	tbody {
		display:table-row-group;
	}
	h3 { margin-bottom: -17px }
	h2 { margin-bottom: 0px }
</style>
<style type="text/css" media="screen">
	table {border: solid 1px #000; border-collapse: collapse; width: 100%}
	tr { border: solid 1px #000}
	th {
		font-family:Arial;
		color:black;
		font-size: 11px;
		background-color: #999;
		padding: 8px 0;
	}
	td { padding: 7px 5px;font-size: 10px}
	h3 { margin-bottom: -17px }
	h2 { margin-bottom: 0px }
</style>
</head>

<body onload="window.print()">

	<center><b style="font-size: 20px">DAFTAR USULAN ANALISA JARINGAN PERPIPAAN 
	<br>SEKSI ANALISA JARINGAN DAN GIS BAGIAN PKA</b><br>
	Dari tanggal <b><?php echo tgl_jam_sql($tgl_start)."</b> sampai dengan tanggal <b>".tgl_jam_sql($tgl_end)."</b>"; ?>
	</center><br>
	<table border="1" cellpadding="5">
	
		<thead>
		<tr>
            <th rowspan="2" >No</th>
            <th colspan="2" >Tanggal</th>
			<th rowspan="2">unit pelayanan</td>
			<th rowspan="2">Disposisi</td>
			<th rowspan="2">uraian usulan</td>
			<th rowspan="2">kesimpulan analisa</td>
			<th rowspan="2">keterangan</td>
        </tr>
        <tr>
            <th>usulan masuk</th>
            <th>surat balasan</th>
        </tr> 
		</thead>   
		<tbody>
			<?php 
			if (!empty($data)) {
				$no = 1;
				foreach ($data as $d) {
					
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo tgl_jam_sql($d->usulan_masuk); ?></td>	
				<td><?php echo tgl_jam_sql($d->surat_balasan); ?></td>
				<td><?php echo $d->unit_pelayanan; ?></td>
				<td><?php echo $d->disposisi; ?></td>
				<td><?php echo $d->uraian_usulan; ?></td>
				<td><?php echo $d->kesimpulan_analisa; ?></td>
				<td><?php echo $d->keterangan; ?></td>
			</tr>
			<?php 

				$no++;}
			} else {
				echo "<tr><td style='text-align: center'>Tidak ada data</td></tr>";
			}
			?>
		</tbody>
	</table>
</body>
</html>

