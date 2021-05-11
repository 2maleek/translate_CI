<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		        = "act_edt";
	$idp		        = $datpil->id;
	$usulan_masuk       = $datpil->usulan_masuk;
	$surat_balasan      = $datpil->surat_balasan;
	$unit_pelayanan     = $datpil->unit_pelayanan;
	$disposisi	        = $datpil->disposisi;
	$uraian_usulan      = $datpil->uraian_usulan;
	$kesimpulan_analisa	= $datpil->kesimpulan_analisa;
	$keterangan		    = $datpil->keterangan;
	$status		        = $datpil->status;
	
} else {
	$act		        = "act_add";
	$idp		        = "";
	$usulan_masuk	    = "";
	$surat_balasan     = "";
	$unit_pelayanan	    = "";
	$disposisi		    = "";
	$uraian_usulan   	= "";
	$kesimpulan_analisa	= "";
	$keterangan		    = "";
	$status		        = "";
}
?>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 style="margin-top: 5px">Surat usulan</h3></div>
	</div>

	<form action="<?php echo base_URL(); ?>surat/surat_masuk/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	
	<div class="row-fluid well" style="overflow: hidden">
		
	<div class="col-lg-6">
		<table  class="table-form">
		<tr><td width="20%">Usulan Masuk</td><td><b><input type="date" name="usulan_masuk" tabindex="7"  value="<?php echo $usulan_masuk; ?>" id="usulan_masuk" style="width: 200px" class="form-control"></b></td></tr>	
		<tr><td width="20%">Surat Balasan</td><td><b><input type="date" name="surat_balasan" tabindex="7"  value="<?php echo $surat_balasan; ?>" id="surat_balasan" style="width: 200px" class="form-control"></b></td></tr>		
		<tr><td width="20%">Unit Pelayanan</td><td><b><input type="text" name="unit_pelayanan" tabindex="2" value="<?php echo $unit_pelayanan; ?>" id="unit_pelayanan" style="width: 400px" class="form-control"></b></td></tr>		
		<tr><td width="20%">Disposisi</td><td><b>
			<select name="disposisi" class="form-control" style="width: 200px" tabindex="6" ><option value=""> - Disposisi - </option>
			<?php
				$f_sifat	= array('Dirut','Dirum','Dirops','Dirtek');
				
				for ($i = 0; $i < sizeof($f_sifat); $i++) {
					if ($f_sifat[$i] == $disposisi) {
						echo "<option selected value='".$f_sifat[$i]."'>".$f_sifat[$i]."</option>";
					} else {
						echo "<option value='".$f_sifat[$i]."'>".$f_sifat[$i]."</option>";
					}				
				}			
			?>	
		</select>
			</b></td></tr>
		<tr><td colspan="2">
		<br><button type="submit" class="btn btn-primary"tabindex="10" ><i class="icon icon-ok icon-white"></i> Simpan</button>
		<a href="<?php echo base_URL(); ?>surat/surat_masuk" class="btn btn-success" tabindex="11" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
		</td></tr>
		</table>
	</div>
	
	<div class="col-lg-6">	
		<table  class="table-form">
		<tr><td width="20%">Uraian Usulan</td><td><b><textarea name="uraian_usulan" tabindex="4" style="width: 400px; height: 90px" class="form-control"><?php echo $uraian_usulan; ?></textarea></b></td></tr>	
		<tr><td width="20%">Kesimpulan Analisa</td><td><b><textarea name="kesimpulan_analisa" tabindex="4" style="width: 400px; height: 90px" class="form-control"><?php echo $kesimpulan_analisa; ?></textarea></b></td></tr>	
		<tr><td width="20%">Keterangan</td><td><b><input type="text" name="keterangan" value="<?php echo $keterangan; ?>" tabindex="9" style="width: 400px" class="form-control"></b></td></tr>	
		<tr><td width="20%">File Surat (Scan)</td><td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 200px"></b></td></tr>

		<tr>
			<td width="20%">Status Surat</td>
			<td>
				<input type="radio" name="status" class="form-check-input"  value="Sudah Lengkap" id="radio1" required> 
				<label for="radio1" class="form-check-label" >Sudah Lengkap</label>
				<br>
				<input type="radio" name="status" class="form-check-input" value="Belum Lengkap" id="radio2" required> 
				<label for="radio2" class="form-check-label">Belum Lengkap</label>
			</td>
		</tr>
		
		</table>	
	</div>

	</div>
	
	</form>
