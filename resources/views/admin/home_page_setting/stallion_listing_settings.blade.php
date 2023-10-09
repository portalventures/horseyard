@extends('admin.layouts.master')
@section('pagetitle', 'Manage Home Page Content')
@section('content')
    <div class="main-content">
        <!-- Latest Listings -->
        <section>
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="page-title">Stallion listings slider</h2>
                <!-- div class="d-flex align-items-center justify-content-between toolbar-option">
                                                                Items in slider:
                                                                <select name="options" id="latest-items-count" class="ml-1">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                              </select>
                                                              </div> -->
            </div>
            <table class="table listing-table mt-4">
                <thead>
                    <tr>
                        <th class="table-drag">&nbsp;</th>
                        <th class="table-image">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="latest-list">
                    @foreach ($stallion_listings as $key => $ad)
                        @php
                            $listing_image = get_listing_first_image($ad->listing_master_id);
                        @endphp
                        <tr>
                            <td class="table-drag">
                                <span class="icon drag-handle"></span>
                            </td>
                            <td class="table-image">
                                @if (!empty($listing_image))
                                    <img src="{{ url($listing_image->image_url . '/' . $listing_image->image_name) }}"
                                        alt="Stallion listing" class="img-fluid" />
                                @else
                                    <img src="{{ url('/noimage.jpg') }}" alt="No Image" class="img-fluid" />
                                @endif
                            </td>
                            <td>{{ $ad->title }}</td>
                            <td>{{get_to_category_name($ad->category_id)}}</td>
                            <td>{{ get_state_name($ad->state_id) }}</td>
                            <td>${{ $ad->price }}</td>
                            <td class="table-actions">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="remove-listing delete_featured_listing_blog"
                                        data-id="{{ $ad->listing_master_id }}" data-object="stallion">
                                        <span class="icon close"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="align-middle">
                            Showing {{ $stallion_listings->firstItem() }} to {{ $stallion_listings->lastItem() }} of
                            total
                            {{ $stallion_listings->total() }} items
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="single-item">
                            @if ($stallion_listings->total() < 10)
                                <a href="{{ url('admin/add-homepage-setting-listing') }}/{{ 'stallion' }}"
                                    class="btn btn-primary">
                                    Add new item
                                </a>
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
        </section>
    </div>
@endsection

@push('custom-scripts')
    <script type="text/javascript"
        src="{{ asset('/admin/custom_js_css/js/home_page_setting.js') }}?v={{ CSS_JS_VER }}"></script>
@endpush
