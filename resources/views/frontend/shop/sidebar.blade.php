<div class="shop-sidebar mr-50">
    <div class="sidebar-widget mb-40">
        <h3 class="sidebar-title">CATEGORIES</h3>
            @foreach($categories_menu as $category_menu)
            <div class="py-2 px-4 bg-dark text-white mb-3">
                <strong class="small text-uppercase font-weight-bold">
                    <a class="text-decoration-none text-white" href="{{ route('shop.index', $category_menu->slug) }}">
                        {{ $category_menu->name }}
                    </a>
                </strong>
            </div>
            <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                    @foreach($category_menu->children as $child)
                    <li class="mb-2">
                        <a class="reset-anchor text-decoration-none px-3" style="color: #000;" href="{{ route('shop.index', $child->slug) }}">
                            {{ $child->name }}
                        </a>
                    </li>
                    @endforeach
            </ul>
            @endforeach 
    </div>
    <div class="sidebar-widget mb-40">
        <h3 class="sidebar-title">TAGS</h3>
        <hr style="margin-top: 0; margin-bottom: 10px; border: solid 1px;">
        <div class="price_filter">
          
            <div class="price_slider_amount">
                <div class="sidebar-categories">
                    <ul>
                        @foreach($tags_menu as $tag_menu)
                            <span style="background: #ebebeb none repeat scroll 0 0; color: #333;
                            display: inline-block; font-size: 12px; line-height: 20px; margin:
                            5px 5px 0 0; padding: 5px 15px; text-transform: capitalize;">
                                <a href="{{ route('shop.tag', $tag_menu->slug) }}" class="text-decoration-none" style="color: #000;">
                                    {{ $tag_menu->name }}
                                    ({{ $tag_menu->products_count }})
                                </a>
                            </span>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-widget mb-40">
        <h3 class="sidebar-title">RECENT REVIEWS</h3>
        <hr style="margin-top: 0; margin-bottom: 10px; border: solid 1px;">
        <ul>
        
                <li>
                    <div class="post-wrapper d-flex">
                        <div class="mb-2">
                            <img src="#" alt="">
                        </div>
                        <div class="ml-3 p-0">
                            
                                <p>
                                    <span class=""></span>
                                    <small> review on :
                                        
                                    </small>
                                </p>
                                <p></p>
                      

                                <h6><span class="text-success">review name</span>
                                    <small> review : </small>
                                </h6>
                                <p>Lorem ipsum dolor sit amet.</p>

                         
                        </div>
                    </div>
                </li>
          
        </ul>
    </div>
</div>
