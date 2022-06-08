<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
      <meta name="author" content="Nur ismaya" />
   
  </head>

  <body>
<style>
@page { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; }
body { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; }
</style>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
        <thead>
            <tr class="row0">
            @foreach($data['head'] as $value)
            <td style="background-color:grey;text-align: left"><?= str_replace('_',' ',$value) ?></td>
            @endforeach
          </tr>
        </thead>
        <tbody>
            @foreach($data['body'] as $va)
            <tr>
              @foreach($data['head'] as $value)
                <td style="text-align: left">{{$va[$value]??''}}</td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
    </table>
  </body>
</html>
