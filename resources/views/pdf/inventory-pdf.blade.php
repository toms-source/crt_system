<!DOCTYPE html>
<html>

<head>
    <title>{{ $inventory->prepared_by }} - RTO Inventory PDF</title>
    <style>
        body {
            font-family: "Nunito", sans-serif;
            font-size: 12px;
            margin: 20px;
        }


        table {
            width: 100%;
            border-collapse: collapse;

        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .br {
            margin: 10px 0;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .foot {
            text-transform: uppercase;

        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Info Section -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 48%; vertical-align: top; border: none; margin-left: 20px;">
                <img src="{{ public_path('images/TranscoLogo.png') }}" alt="TranscoLogo" style="width: 100px;">
                <p style="color: red; margin: 5px 0; font-weight:bold; font-size:x-large;">National Transmission Corporation</p>
            </td>
            <td style="width: 48%; vertical-align: top; border: none;">
                <h1 class="uppercase bold" style="font-size: 16px; margin: 10px 0;">RECORDS TURN-OVER / INVENTORY LIST FORM</h1>
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 48%; vertical-align: top;">
                <p class="uppercase"><strong>Office Origin:</strong> <span style="text-transform: capitalize;">{{ $inventory->office_origin}}</span></p>
                <p class="uppercase"><strong>Turn-Over Date:</strong> <span style="text-transform: capitalize;">{{ \Carbon\Carbon::parse($inventory->created_at)->format('M-d<strong>-Y') }}</span></p>
            </td>
            <td style="width: 48%; vertical-align: top;">
                <p class="uppercase"><strong>Prepared/Turn-over By:</strong> <span style="text-transform: capitalize;">{{ $inventory->prepared_by}}</span></p>
                <p class="uppercase"><strong>Approved By:</strong> <span style="text-transform: capitalize;">{{$inventory->manager_approval}}</span></p>
            </td>
        </tr>
    </table>

    <!-- Table Section -->
    <table>
        <thead>
            <tr>
                <th>Item No</th>
                <th class="uppercase">Document Description</th>
                <th class="uppercase">Doc Date</th>
                <th class="uppercase">Quantity/Unit Code</th>
                <th class="uppercase">Index Code</th>
                <th class="uppercase">Status</th>
                <th class="uppercase">Retention Period</th>
                <th class="uppercase">Disposal Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $inventory->id }}</td>
                <td>{{ $inventory->description }}</td>
                <td>{{ \Carbon\Carbon::parse($inventory->doc_date)->format('Y') }}</td>
                <td>{{ $inventory->quantity_code }}</td>
                <td>{{ $inventory->index_code }}</td>
                <td style="color: {{ $inventory->status === 'Permanent' ? 'blue' : ($inventory->status === 'Temporary' ? 'orange' : 'black') }}">
                    {{ $inventory->status }}
                </td>
                <td>{{ $inventory->retention_period }} <span style="margin-right: 2px; text-transform:uppercase;">year/s</span></td>
                <td>{{ \Carbon\Carbon::parse($inventory->disposal_date)->format('Y') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="br">
        <div>-----------------------------------------------------------------------------------------------<span>TO BE FILLED BY RECORDS PERSONNEL</span>---------------------------------------------------------------------------------------------</div>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 48%; vertical-align: top; border: none; margin-left: 20px;">
                <p class="foot"><strong>INVENTORY LIST NO.:</strong></p>
                <p class="foot"><strong>DISPOSAL SERIES NO.:</strong></p>
                <p class="foot"><strong>LOC CODE:</strong></p>
            </td>
            <td style="width: 48%; vertical-align: top; border: none;">

                <p class="foot"><strong>recieved by: </strong> {{ $inventory->recieved_by}}
                    @if(!empty($inventory->recieved_by))
                    - {{ \Carbon\Carbon::parse($inventory->recieve_date)->format('M-d-Y') }}
                    @endif
                </p>
                <p class="foot"><strong>approved by:</strong> {{ $inventory->approved_by}}
                    @if(!empty($inventory->approved_by))
                    - {{ \Carbon\Carbon::parse($inventory->approve_date)->format('M-d-Y') }}
                    @endif
                </p>
            </td>
        </tr>
    </table>

</body>

</html>