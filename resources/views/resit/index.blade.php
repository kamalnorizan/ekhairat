
<div id="printable-content">
    <div class="card">
        <div class="card-body" id="pageBody">
            <table width="100%">
                <tr>
                    <td colspan="2">
                        <center><img src="{{ asset('resFront/images/logo.png') }}" width="100%" alt="Image" class="footer-logo" style="margin-bottom: 5px; max-width: 150px;"><br>
                        <small><strong>BADAN KHAIRAT KEMATIAN, SURAU AL-HIDAYAH, BANDA SAUJANA PUTRA.</strong><br>
                        NO 1, JALAN SP7/2, BANDAR SAUJANA PUTRA,
                        42610 JENJAROM SELANGOR.<br>
                        https://ekhairatsahbsp.com/ || email : bbksahbsp@gmail.com</center></small>
                        {{-- <div class="divider divider-rounded divider-center"><i class="icon-map-marker"></i></div> --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>NAMA : </strong>{{strtoupper($bayaran->keahlian->nama)}}<br>
                        <strong>NO TEL : </strong>{{strtoupper($bayaran->keahlian->notel_hp)}}<br>
                        <strong>EMEL : </strong>{{$bayaran->keahlian->user->email}}<br>

                    </td>
                    <td valign="top" style="text-align: right!important">
                        <h4 class="card-title text-danger" id="txtResit">RESIT # : {{$bayaran->noresitnew}}</h4>
                        TARIKH : {{\Carbon\Carbon::parse()->format('d-m-Y')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width=100% class="detailTbl" style="margin-top:15px">
                            <thead style="background-color: green;color:white">
                                <tr>
                                    <th width="10%">Bil</th>
                                    <th width="70%">Perkara</th>
                                    <th width="20%">Jumlah(RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $row=0;
                                @endphp
                                @foreach ($bayaran->bayaranDetails as $key=>$detail)
                                <tr>
                                    <td align="center">
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        {{$detail->jenis=='yuran' ? 'TAHUN '.$detail->tahun : 'DERMA'}}
                                    </td>
                                    <td style="text-align: right!important">
                                        {{number_format($detail->amaun,2)}}
                                    </td>
                                </tr>
                                @php
                                    $row++;
                                @endphp
                                @endforeach
                                @for ($i = $row; $i < 5; $i++)
                                <tr>
                                    <td align="center">
                                        &nbsp;
                                    </td>
                                    <td>

                                    </td>
                                    <td style="text-align: right!important">

                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="text-align: right!important">
                                        <strong>JUMLAH KESELURUHAN</strong>
                                    </td>
                                    <td style="text-align: right!important">
                                        <strong>{{number_format($bayaran->jumlahbayaran,2)}}</strong>
                                    </td>
                                </tr>

                            </tfoot>
                        </table>

                        <br>
                        <div class="copTarikh" >{{\Carbon\Carbon::parse($bayaran->created_at)->format('d-m-Y')}}</div>
                        <img src="{{ asset('images/cop.png') }}" class="cop" style="max-width: 150px;" alt="">
                        <center><strong>~ TERIMA KASIH ~</strong></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">

                        <hr class="bottomBorder">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <i><strong>Nota : </strong>Resit adalah janaan komputer dan tiada tandatangan diperlukan.</i>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
 function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
