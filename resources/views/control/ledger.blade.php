<table class="table table-bordered table-striped table-sm mt-2 p-0 ">
    <thead>
        <tr>
            <th class="align-middle">Date</th>
            <th class="align-middle">Detail</th>
            <th class="align-middle">A/Received</th>
            <th class="align-middle">Vorc No</th>
            <th class="align-middle">Commodity</th>
            <th class="align-middle">Bags</th>

            <th class="align-middle">Gross <br>/wt (kg)</th>
            <th class="align-middle">Tares</th>
            <th class="align-middle">Moisture <br>/dis</th>

            <th class="align-middle">Net<br>/wt (kg)</th>

            <th class="align-middle">Price (₦)</th>

            <th class="align-middle">Amount</th>
            <th class="align-middle">B/Debit</th>
            <th class="align-middle">B/Credit</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($stocks as $stock)
            @php
                $amount_paid = getAmmountPaid($stock->summary_id);
            @endphp

            @php
                $str =
                    $stock->current_balance > 0
                        ? '<td> - </td>
                        <td>' .
                            money($stock->current_balance) .
                            ' </td>'
                        : '<td>' .
                            money($stock->current_balance) .
                            '</td>
                        <td> - </td>';
            @endphp

            @if ($stock->action == 'export')
                <tr>
                    <td> {{ $stock->created_at }} </td>
                    <td> Exported </td>
                    <td> - </td>
                    <td> - </td>
                    <td>{{ $stock->product->name }} </td>
                    <td> {{ number_format(abs($stock->bags)) }} </td>
                    <td> {{ number_format(abs($stock->gross_weight)) }} </td>

                    <td> {{ abs($stock->tares) }} </td>
                    <td> {{ number_format(abs($stock->moisture_discount)) }} </td>
                    <td> {{ number_format(abs($stock->net_weight)) }} </td>
                    <td> {{ money($stock->price) }} </td>
                    <td> {{ money($stock->total) }} </td>

                    {!! $str !!}

                </tr>
            @elseif ($stock->action == 'import')
                <tr>
                    <td> {{ $stock->created_at }} </td>
                    <td> Supplied </td>
                    <td> - </td>
                    <td> - </td>
                    <td>{{ $stock->product->name }} </td>
                    <td> {{ number_format(abs($stock->bags)) }} </td>
                    <td> {{ number_format(abs($stock->gross_weight)) }} </td>

                    <td> {{ abs($stock->tares) }} </td>
                    <td> {{ number_format(abs($stock->moisture_discount)) }} </td>
                    <td> {{ number_format(abs($stock->net_weight)) }} </td>
                    <td> {{ money($stock->price) }} </td>
                    <td> {{ money($stock->total) }} </td>
                    {!! $str !!}

                </tr>
            @elseif($stock->action == 'capital')
                <tr>
                    <td> {{ $stock->created_at }} </td>
                    <td> {{ $stock->bank }} Capital </td>

                    <td> {{ money($stock->total) }} </td>
                    <td> {{ $stock->vocher_number ?? '-' }} </td>
                    <td>-</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>

                    {!! $str !!}

                </tr>
            @elseif(
                $stock->action == 'moisture adjustment' ||
                    $stock->action == 'price adjustment' ||
                    $stock->action == 'tares adjustment')
                @php
                    $action_array = explode(' ', $stock->action);
                    print_r($action_array);
                @endphp
                <tr>
                    <td> {{ $stock->created_at }} </td>
                    <td> {{ $stock->action }} </td>

                    <td>-</td>
                    <td>-</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> {{ $stock->moisture_discount ?? '-' }} </td>
                    <td> - </td>
                    <td> {{ $stock->price ?? '-' }} </td>
                    <td> {{ money($stock->total) }} </td>

                    {!! $str !!}

                </tr>
            @endif
        @endforeach

    </tbody>
</table>
