<div class="text-center">
    @can($canEdit)
        @if ($trasaction)
            <button type="button" class="btn btn-light btn-xs disabled py-0 px-1">
                <i class="fas fa-user-edit"></i>
            </button>
        @else
            <a href="{{ $urlEdit }}" class="btn btn-warning btn-form btn-xs py-0 px-1" title="Edit">
                <i class="fas fa-user-edit"></i>
            </a>
        @endif
    @endcan

    @can($canDelete)
        @if ($stock)
            <button type="button" class="btn btn-light btn-xs disabled py-0 px-1">
                <i class="fas fa-trash"></i>
            </button>
        @else
            <a href="{{ $urlDestroy }}" class="btn btn-danger btn-delete btn-xs py-0 px-1" data-text="{{ $msgDelete }}" title="Delete">
                <i class="fas fa-trash"></i>
            </a>
        @endif
    @endcan
</div>
