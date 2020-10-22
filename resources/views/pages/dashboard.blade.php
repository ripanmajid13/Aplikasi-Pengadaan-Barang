@extends('layouts.app')

@push('style_plugin')
@endpush

@push('script_plugin')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $item }}</h3>
                    <p>Total Barang</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $supplier }}</h3>
                    <p>Total Supplier</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                    <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
    </div>





    <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Buttons
          </h3>
        </div>
        <div class="card-body pad table-responsive">
          <p>Various types of buttons. Using the base class <code>.btn</code></p>
          <table class="table table-bordered text-center">
            <tr>
              <th>Normal</th>
              <th>Large <code>.btn-lg</code></th>
              <th>Small <code>.btn-sm</code></th>
              <th>Extra Small <code>.btn-xs</code></th>
              <th>Flat <code>.btn-flat</code></th>
              <th>Disabled <code>.disabled</code></th>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-default">Default</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-default btn-lg">Default</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-default btn-sm">Default</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-default btn-xs">Default</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-default btn-flat">Default</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-default disabled">Default</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-primary">Primary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-primary btn-lg">Primary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-primary btn-sm">Primary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-primary btn-xs">Primary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-primary btn-flat">Primary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-primary disabled">Primary</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-secondary">Secondary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-secondary btn-lg">Secondary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-secondary btn-sm">Secondary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-secondary btn-xs">Secondary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-secondary btn-flat">Secondary</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-secondary disabled">Secondary</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-success">Success</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-success btn-lg">Success</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-success btn-sm">Success</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-success btn-xs">Success</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-success btn-flat">Success</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-success disabled">Success</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-info">Info</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-info btn-lg">Info</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-info btn-sm">Info</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-info btn-xs">Info</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-info btn-flat">Info</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-info disabled">Info</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-danger">Danger</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-danger btn-lg">Danger</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-danger btn-sm">Danger</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-danger btn-xs">Danger</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-danger btn-flat">Danger</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-danger disabled">Danger</button>
              </td>
            </tr>
            <tr>
              <td>
                <button type="button" class="btn btn-block btn-warning">Warning</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-warning btn-lg">Warning</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-warning btn-sm">Warning</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-warning btn-xs">Warning</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-warning btn-flat">Warning</button>
              </td>
              <td>
                <button type="button" class="btn btn-block btn-warning disabled">Warning</button>
              </td>
            </tr>
            <tr>
                <td>
                  <button type="button" class="btn btn-block btn-light">Light</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-light btn-lg">Light</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-light btn-sm">Light</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-light btn-xs">Light</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-light btn-flat">Light</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-light disabled">Light</button>
                </td>
              </tr>
              <tr>
                <td>
                  <button type="button" class="btn btn-block btn-dark">Dark</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-dark btn-lg">Dark</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-dark btn-sm">Dark</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-dark btn-xs">Dark</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-dark btn-flat">Dark</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-dark disabled">Dark</button>
                </td>
              </tr>
              <tr>
                <td>
                  <button type="button" class="btn btn-block btn-link">Link</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-link btn-lg">Link</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-link btn-sm">Link</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-link btn-xs">Link</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-link btn-flat">Link</button>
                </td>
                <td>
                  <button type="button" class="btn btn-block btn-link disabled">Link</button>
                </td>
              </tr>
          </table>
        </div>
@endsection
