<div>
    <!-- CSS -->
    <style type="text/css">
        .search-box .clear {
            clear: both;
            margin-top: 20px;
        }

        .search-box ul {
            list-style: none;
            padding: 0px;
            margin: 0;
            background: white;
        }

        .search-box ul li {
            background: lavender;
            padding: 4px;
            margin-bottom: 1px;
        }

        .search-box ul li:nth-child(even) {
            background: cadetblue;
            color: white;
        }

        .search-box ul li:hover {
            cursor: pointer;
        }
    </style>

    <div class="search-box">
        <input type='text' wire:model="qurey" class="form-control" placeholder="Orisoft employee code">
        @if ($results)
            <!-- Search result list -->
            <ul class=" form-control  form-control-solid mb-lg-0">
                @foreach ($results as $record)
                    <li wire:click="select({{ $record->id }})">{{ $record->orisoft_no }} : {{ $record->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
