<div class="text-center">
    @can($canEdit)
        <a href="{{ $urlEdit }}" class="btn btn-warning btn-form btn-xs py-0 px-1" title="Edit">
            <i class="fas fa-user-edit"></i>
        </a>
    @endcan

    @can($canDelete)
        <a href="{{ $urlDestroy }}" class="btn btn-danger btn-delete btn-xs py-0 px-1" data-text="{{ $msgDelete }}" title="Delete">
            <i class="fas fa-trash"></i>
        </a>
    @endcan
</div>
