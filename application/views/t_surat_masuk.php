<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<div class="clearfix">

	<div class="panel panel-info">
		<div class="panel-heading" style="overflow: auto">
			<div class="col-md-2">
				<h3 style="margin-top: 5px">Surat usulan</h3>
			</div>
			<?php
		if ($this->session->userdata('admin_level') == "super admin") {
			?>
			<div class="col-md-2">
				<a href="<?php echo base_URL(); ?>surat/surat_masuk/add" class="btn btn-info"><i
						class="icon-plus-sign icon-white"> </i> Tambah Data</a>
			</div>
			<div class="col-md-4"></div>
			<?php
		}
		?>
			</form>
		</div>
	</div>
</div>

<?php echo $this->session->flashdata("k");?>

<form action="<?php echo base_URL(); ?>Surat/cetak_surat_masuk" method="post">
	<table id="tabel-data" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th rowspan="2">Cetak</th>
				<th rowspan="2">No</th>
				<th colspan="2">Tanggal</th>
				<th rowspan="2">Unit Pelayanan</th>
				<th rowspan="2">Disposisi</th>
				<th rowspan="2">Uraian Usulan</th>
				<th rowspan="2">Kesimpulan Analisa</th>
				<th rowspan="2">Keterangan</th>
				<th rowspan="2">Status</th>
				<th rowspan="2">Aksi</th>
			</tr>
			<tr>
				<th>usulan masuk</th>
				<th>surat balasan</th>
			</tr>
		<tbody>
			<?php 
				if (empty($data)) {
					echo "<tr><th colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</th></tr>";
				} else {
					$no 	= ($this->uri->segment(4) + 1);
					foreach ($data as $b) {
			?>
			<tr>
				<th>
					<input type="checkbox" name="cetak[]" value="<?php echo $b ->id;?>">
				</th>
				<th><?php echo $no;?></th>
				<th><?php echo $b->usulan_masuk ?></th>
				<th><?php echo $b->surat_balasan ?></th>
				<th><?php echo $b->unit_pelayanan?></th>
				<th><?php echo $b->disposisi?></th>
				<th><?php echo $b->uraian_usulan."<br><b>File : </b><i><a href='".base_URL()."upload/surat_masuk/".$b->file."' target='_blank'>".$b->file."</a>"?>
				</th>
				<th><?php echo $b->kesimpulan_analisa?></th>
				<th><?php echo $b->keterangan?></th>
				<th><?php echo $b->status ?></th>
				<th class="ctr">
					<?php  
				if ($b->pengolah == $this->session->userdata('admin_id')) {
				?>
					<div class="btn-group">
						<a href="<?php echo base_URL()?>surat/surat_masuk/edt/<?php echo $b->id?>"
							class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i>
							Edt</a>
						<a href="<?php echo base_URL()?>surat/surat_masuk/del/<?php echo $b->id?>"
							class="btn btn-warning btn-sm" title="Hapus Data"
							onclick="return confirm('Anda Yakin..?')"><i class="icon-trash icon-remove"> </i> Del</a>
					</div>
					<?php 
				} else {
				?>
					<div class="btn-group">
						<a href="<?php echo base_URL()?>surat/surat_masuk/edl/<?php echo $b->id?>"
							class="btn btn-info btn-sm" target="_blank" title="Lihat"><i
								class="icon-eye-open icon-white"> </i></a>
					</div>
					<?php 
				}
				?>
				</th>

			</tr>
			<?php 
			$no++;
			}
		}
		?>

		</tbody>
	</table>
	<?php
		if ($this->session->userdata('admin_level') == "super admin") {
	?>
		<button type="submit" class="btn btn-info" target="_blank"><i class="icon-print icon-white"></i> Cetak </button>
	<?php
		}
	?>
</form>

</div>
<script>
	$(document).ready(function () {
		$('#tabel-data').DataTable();
	});
</script>
</div>
