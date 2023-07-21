            <!-- Right side column. Contains the navbar and content of the page -->
            <!--<aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Tables
                        <small>advanced tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Tables</a></li>
                        <li class="active">Data tables</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Master Pegawai</h3>                                    
                                </div><!-- /.box-header -->
								<?php 
									include("./inc/config.php");
									$tampil = mysqli_query($connect,"SELECT * FROM mst_pegawai");
								?>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
										<thead>
										<tr>
											<th width='50'>No.</th>
											<th>NIP</th>
											<th>Nama</th>
											<th>No. Rekening</th>
											<th>Bank</th>
											<th>Aktif</th>
											<th>Aksi</th>
										</tr>
										</thead>
										<?php
											$no=1;
											while($k=mysqli_fetch_assoc($tampil)){
												echo "<tr>
													<td align='center'>$no</td>
													<td><u><a href='?m=mst_pegawai&tipe=detail&id=$k[id]'><font color='blue'>$k[nip]</font></a></u></td>
													<td>$k[nama_alias]</td>
													<td>$k[norek]</td>
													<td>$k[bank]</td>
													<td width='70' align='center'>$k[aktif]</td>
													<td align='center' width='140px'>
														<a class='btn btn-info' href='?m=mst_pegawai&tipe=edit&id=$k[id]'>Edit</a>";
														echo " <a class='btn btn-danger' href='module/mst_pegawai/proses_hapus.php?id=$k[id]&kode=$k[nip]'
														onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
													echo "</td>";
												$no++;
											}
										?>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            <!--</aside><!-- /.right-side -->
