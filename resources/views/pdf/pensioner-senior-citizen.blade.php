
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>List of Pensioner PWD</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    tbody tr td{
        border: 1px solid black;
    }
    th{
        border: 1px solid black;
    }
    .gray {
        background-color: lightgray
    }
    .pagenum:before {
        content: counter(page);
    }
    .wrapper-page {
    page-break-after: always;
    }

    .wrapper-page:last-child {
        page-break-after: avoid;
    }
    .page-break {
        page-break-after: always;
    }
    
    #footer {
        position: fixed;
        right: 20px;
        bottom: 0;
        text-align: right;
        }
    #footer .page:after {
        content: counter(page);
    }
    .copyRight{
      font-size: 10px;
      font-style: italic;
      padding-bottom: 0px;
      margin-bottom:0px;
    }
    .page{
      font-size: 12px;
      font-style: bold;
    }
    
</style>

</head>
<body>

@foreach ($sitios as $sitiokey => $sitio)
@if($loop->index!=1)
  <div id="footer">  
    <!-- <span class="copyRight">© ICTMO, Partido State University</span> -->
    <table width="100%" style="border: none !important; ">
    <tr>
        <!-- <td valign="top" width="500" style="border: none !important;"><img src="images/lgu_goa_logo.png" alt="" width="70"/></td> -->
        <td align="right" style="border: none !important;">
            <p >
                <span class="page">Page </span><br>
                <span class="copyRight" style="padding-bottom: 0px; margin-bottom:0px;">List of Unregistered PWD - {{$sitio['barangay']}} </span><br/>
                <span class="copyRight"  style="padding-bottom: 0px; margin-bottom:0px;">Generated by https://e-sitio.parsu.edu.ph</span><br/>
                <span class="copyRight">© ICTMO, Partido State University</span>
            </p>
        </td>
    </tr>
  </table>
  </div>
  @endif
<table width="100%" style="border: none !important; ">
    <tr>
        <td valign="top" width="500" style="border: none !important;"><img src="images/lgu_goa_logo.png" alt="" width="70"/></td>
        <td align="left" style="border: none !important;">
            <p >
            <b>Province:</b> CAMARINES SUR, V - BICOL REGION <br>
                <b>City/Municipality:</b> Goa <br>
                <b>Office:</b> PWD <br>
                <b>Report:</b>List of Pensioner PWD<br>
                <b>Barangay:</b> {{ $sitio['barangay']}} <br>
                <b>Sitio:</b> {{$sitio['name']}} <br>
                <b>Generated Date:</b> {{ $date }}
            </p>
        </td>
    </tr>

  </table>
  <br/>
  <table width="100%" style="border: 1px solid black; border-collapse: collapse; padding-bottom:80px">
    <thead style="background-color: lightgray; border: 1px solid black;">
      
      <tr>
        <th>#</th>
        <th>HCN</th>
        <th>Name</th>
        <th>Sex</th>
        <th>Age</th>
        <th>Birthdate</th>
      </tr>
    </thead>
    <tbody>
    @if(count($sitio['constituents'])!=0)
    @foreach ($sitio['constituents'] as $key => $constituent)
      <tr>
        <th scope="row">{{$key+1}}</th>
        <td align="center">{{$constituent['hcn']}}</td>
        <td align="left" style="padding-left: 50px;">{{$constituent['name']}}</td>
        <td align="left" style="padding-left: 50px;">{{$constituent['sex']}}</td>
        <td align="left" style="padding-left: 50px;">{{$constituent['age']}}</td>
        <td align="left" style="padding-left: 50px;">{{$constituent['bday']}}</td>
      </tr>
    @endforeach
    @else
    <tr>
        <td colspan="6" align="center">No record</td>
      </tr>
    @endif
    </tbody>
  </table>
  @if(count($sitios) != $loop->index+1)
  <div class="page-break"></div>
  @endif
  
 
  @endforeach
</body>


</html>