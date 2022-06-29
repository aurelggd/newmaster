<x-app-layout>
    <x-slot name="header">
        <!--<h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bo rr rd') }}
        </h2>-->
        <div class="container">
            <div id="app">
                <form onsubmit="return checkForm();">
                    @csrf

                    <h3> Organiser un vote </h3>

                    <div class="input_div">
                        <label>Date de cloture</label>
                        <x-input id="date" class="block mt-1 w-full" type="date" required autofocus />

                    </div>
                    <div class="input_div">
                        <label>Heure de fin</label>
                        <x-input id="h" class="block mt-1 w-full" type="number" name="number" min="1" max="23" required autofocus />
                    </div>
                    <div class="input_div">
                        <label>Minutes de fin</label>
                        <x-input id="min" class="block mt-1 w-full" type="number" min="0" max="59" required autofocus />
                    </div>
                    <div class="input_div">
                        <label>Secondes de fin</label>
                        <x-input id="sec" class="block mt-1 w-full" type="number" min="0" max="59" required autofocus />
                    </div>
                    <div class="input_div">
                        <label>Choix des votants</label>
                        <x-input class="block mt-1 w-full" onchange="UploadChoixVotants()" id="fileChoixVotants" type="file" accept=".xlsx, .xls" required autofocus />
                    </div>
                    <div class="input_div">
                        <label>Liste des votants</label>
                        <x-input class="block mt-1 w-full" onchange="UploadListVotants()" id="fileListVotants" type="file" accept=".xlsx, .xls" required autofocus />
                    </div>

                    <div class="input_div">
                        <x-button class="mt-1 ">
                            {{ __('LANCER LE VOTE') }}
                        </x-button>
                    </div>
                </form>
            </div>

            <br />
        </div>
    </x-slot>

    <script>
        let dataChoixVotants = null
        let dataListVotants = null

        function UploadListVotants() {
            var fileListVotants = document.getElementById("fileListVotants");

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileListVotants.value.toLowerCase())) {
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function(e) {
                            dataListVotants = GetTableFromExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileListVotants.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function(e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            dataListVotants = GetTableFromExcel(data);
                        };
                        reader.readAsArrayBuffer(fileListVotants.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        };

        function UploadChoixVotants() {
            var fileChoixVotants = document.getElementById("fileChoixVotants");

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileChoixVotants.value.toLowerCase())) {
                if (typeof(FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function(e) {
                            dataChoixVotants = GetTableFromExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileChoixVotants.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function(e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            dataChoixVotants = GetTableFromExcel(data);
                        };
                        reader.readAsArrayBuffer(fileChoixVotants.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        };

        function GetTableFromExcel(data) {
            //Read the Excel File data in binary to protect from console.log ... 
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            //get the name of First Sheet.
            var Sheet = workbook.SheetNames[0];

            //Read all rows from First Sheet into an JSON array.
            var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);

            let allData = [];

            //Add the data rows from Excel file.
            for (var i = 0; i < excelRows.length; i++) {
                allData.push(excelRows[i]);
            }
            return allData
        };

        function toMonthName(monthNumber) {
            const date = new Date();
            date.setMonth(monthNumber - 1);

            return date.toLocaleString('en-US', {
                month: 'long'
            , });
        }

        function checkForm() {

            event.preventDefault();
            //console.log(new Date("June 16, 2022 02:05:00").getTime())

            let year = document.getElementById("date").value.split("-")[0]
            let month = document.getElementById("date").value.split("-")[1]
            let day = document.getElementById("date").value.split("-")[2]

            let hours = document.getElementById("h").value
            let minutes = document.getElementById("min").value
            let seconds = document.getElementById("sec").value

            let finishDate = toMonthName(month) + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ':' + seconds;
            console.log({
                'dateFin': finishDate
                , 'nbrVotants': Object.keys(dataListVotants).length
                , 'choixDeVote': dataChoixVotants
            })
        }

    </script>

    <style>
        .count {
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 5px 8px #ccc;
            margin: 30px 20px;
            border: 1px solid transparent;
            border-radius: 10px;
            height: 150px;
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        form {
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0px 2px 5px #ccc;
            background-color: white;
            padding: 60px 0px;
        }

        form h3 {
            padding: 20px 0px;
            text-align: center;
            font-size: 2em;

        }

        .input_div {
            padding: 8px 0px;
            width: 50%;
            margin: auto;
        }


        @media screen and (max-width: 1000px) {}

    </style>


</x-app-layout>
