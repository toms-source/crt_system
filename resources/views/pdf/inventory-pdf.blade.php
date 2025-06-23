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
    <h4>Inventory Id: {{ $inventory->id }}</h4>
    <table style="width: 100%;">
        <tr>
            <td style="width: 48%; vertical-align: top;">
                <p class="uppercase"><strong>Office Origin:</strong> <span style="text-transform: capitalize;">{{ $inventory->office_origin}}</span></p>
                <p class="uppercase"><strong>Turn-Over Date:</strong> <span style="text-transform: capitalize;">{{ \Carbon\Carbon::parse($inventory->created_at)->format('m/d/Y') }}</span></p>
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
            @foreach ($inventory->items as $item)
            @php
            $disposalDate = \Carbon\Carbon::parse($item->disposal_date);
            $now = \Carbon\Carbon::now();
            $diffInYears = $now->diffInYears($disposalDate, false);
            $color = '';

            if ($diffInYears <= 1) {
                $color='red' ;
                } elseif ($diffInYears > 1) {
                $color = 'green';
                }
                @endphp
                <tr>
                    <td>{{ $item->item_no }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->doc_date)->format('m/d/Y') }}</td>
                    <td>{{ $item->quantity_code }}</td>
                    <td>{{ $item->index_code }}</td>
                    <td>
                        {{ $item->status }}
                    </td>
                    <td>
                        @if ($item->retention_period)
                        {{ $item->retention_period }}
                        <span style="margin-right: 2px; text-transform:uppercase;">year/s</span>
                        @else
                        —
                        @endif
                    </td>

                    <td style="color: {{ $color }}">
                        {{ $item->disposal_date ? \Carbon\Carbon::parse($item->disposal_date)->format('m/d/Y') : '—' }}
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
    <div class="br">
        <div>-----------------------------------------------------------------------------------------------<span>TO BE FILLED BY RECORDS PERSONNEL</span>---------------------------------------------------------------------------------------------</div>
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 48%; vertical-align: top; border: none; margin-left: 20px;">
                <p class="foot"><strong>INVENTORY LIST NO.:</strong> {{ $inventory->list_no }}</p>
                <p class="foot"><strong>DISPOSAL SERIES NO.:</strong> {{$inventory->series_no }}</span></p>
                <p class="foot"><strong>LOC CODE:</strong> {{ $inventory->loc_code }}</p>
            </td>
            <td style="width: 48%; vertical-align: top; border: none;">

                <p class="foot"><strong>recieved by: </strong> {{ $inventory->recieved_by}}
                    @if(!empty($inventory->recieved_by))
                    - {{ \Carbon\Carbon::parse($inventory->recieve_date)->format('m/d/Y') }}
                    @endif
                </p>
                <p class="foot"><strong>approved by:</strong> {{ $inventory->approved_by}}
                    @if(!empty($inventory->approved_by))
                    - {{ \Carbon\Carbon::parse($inventory->approve_date)->format('m/d/Y') }}
                    @endif
                </p>
            </td>
        </tr>
    </table>

</body>

</html>