@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 order-lg-1">
                Please download one of the following Exports, these will provide templates that you can use to upload. Once edited, you can upload it and it will post the changes to the MySQL Server. More Templates will be available. Custom made Templates can be provided by Curtis. <br>
            </div>
            <div class="col-lg-4 order-lg-2" id="corePane">
                <a href="./scripts/php/downloadrotacsv.php"> Download All Current Data </a>
            </div>
            <div class="col-xl-4 order-xl-3" id="corePane">
                <form action="./scripts/php/uploadrotacsv.php" method="post" enctype="multipart/form-data">
                    Select amended export:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload CSV" name="submit">
                </form>
            </div>
        </div>
    </div>
@endsection
