<table class="table table-bordered table-striped table-sm mt-2 p-0 ">
    <thead>
        <tr>
            <th class="align-middle">Date</th>
            <th class="align-middle">Detail</th>
            <th class="align-middle">A/Received</th>
            <th class="align-middle">Bank</th>
            <th class="align-middle">Commodity</th>
            <th class="align-middle">Bags</th>

            <th class="align-middle">Gross <br>/wt (kg)</th>
            <th class="align-middle">Tares</th>
            <th class="align-middle">Moisture <br>/dis</th>

            <th class="align-middle">Net<br>/wt (kg)</th>

            <th class="align-middle">Price (₦)</th>

            {{-- <th class="align-middle">Amount</th>
            <th class="align-middle">B/Debit</th>
            <th class="align-middle">B/Credit</th> --}}
            <th class="align-middle">Debit</th>

            <th class="align-middle">Credit</th>
            <th class="align-middle">Balance </th>
        </tr>
    </thead>
    <tbody>
        @php
            $export_array = [];
        @endphp

        @foreach ($stocks as $stock)
            @php
                $amount_paid = getAmmountPaid($stock->summary_id);
                $role_in = isset($stock->supplier_id) ? 'supplier' : 'exporter';
            @endphp


            @if ($stock->action == 'export')
                @if (!in_array($stock->summary_id, $export_array))
                    <tr>
                        <td> {{ date('j M, Y', strtotime($stock->created_at)) }} </td>
                        <td> Exported </td>
                        <td> - </td>
                        <td> - </td>
                        <td>{{ $stock->product->name }} </td>
                        <td> {{ number_format(abs($stock->sales_sum->bags ?? $stock->sales_sum->sales->sum('bags'))) }} </td>

                        <td> {{ number_format(abs($stock->sales_sum->gross_weight ?? $stock->sales_sum->sales->sum('gross_weight'))) }} </td>

                        <td> {{ abs($stock->tares) }} </td>
                        <td> {{ number_format(abs($stock->sales_sum->moisture_discount ?? $stock->moisture_discount)) }} </td>
                        <td> {{ number_format(abs($stock->sales_sum->net_weight ?? $stock->sales_sum->sales->sum('net_weight'))) }} </td>
                        <td> {{ money($stock->sales_sum->sales_price) }} </td>
                        <td> {{ money($stock->sales_sum->total) }} </td>
                        <td> - </td>

                        <td> {{ money(touchBalance( $stock->sales_sum->sales->last()->id, $stock->customer_id, $role_in)) }}</td>

                    </tr>
                    @php
                        $export_array[] = $stock->summary_id;
                    @endphp
                @endif
            @elseif ($stock->action == 'import')
                <tr>
                    <td> {{ date('j M, Y', strtotime($stock->created_at)) }} </td>
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
                    <td>-</td>
                    <td> {{ money($stock->total) }} </td>
                    <td> {{ money(touchBalance($stock->id, $stock->supplier_id, $role_in)) }} </td>
                </tr>
            @elseif($stock->action == 'capital')
                <tr>
                    <td> {{ date('j M, Y', strtotime($stock->created_at)) }} </td>
                    <td> {{ $stock->remark }} </td>

                    <td> {{ money($stock->total) }} </td>
                    <td> {{ $stock->bank ?? '-' }} </td>
                    <td>-</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    @if ($stock->supplier_id)
                        <td> {{ money($stock->total) }} </td>
                        <td> - </td>
                    @else
                        <td> - </td>
                        <td> {{ money($stock->total) }} </td>
                    @endif

                    <td>
                        {{ money(touchBalance($stock->id, $stock->supplier_id ?? $stock->customer_id, $role_in)) }}
                    </td>


                </tr>
            @elseif($stock->action == 'expenses')
            @else
                <tr>
                    <td> {{ date('j M, Y', strtotime($stock->created_at)) }} </td>
                    <td> {{ $stock->action }} </td>

                    <td>-</td>
                    <td>-</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> {{ $stock->net_weight }} </td>
                    <td> {{ $stock->price }} </td>

                    <td> - </td>

                    <td> {{ money($stock->total) }} </td>


                    <td> {{ money(touchBalance($stock->id, $stock->supplier_id, $role_in)) }} </td>

                </tr>
            @endif
        @endforeach

    </tbody>
</table>
