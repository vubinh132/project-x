<div class="row">
    <div class="col-lg-8 hidden-sm-down">
        <h2 class="payment__title--step text-uper">CHỌN HÌNH THỨC THANH TOÁN</h2>
        <ul class="clearfix payment__steps">
            <li><a class="{{ Request::is('payments/napas') ? 'active' : '' }}"><span class="icons icon-atm"></span>Thẻ
                    ATM</a></li>
            <li><a><span class="icons icon-ttd"></span>Thẻ tín dụng</a></li>
            <li><a class="{{ Request::is('payments/bank-plus') ? 'active' : '' }}"><span
                            class="icons icon-bankplus"></span>Bankplus</a></li>
            <li><a><span class="icons icon-ck"></span>Chuyển khoản</a></li>
        </ul>
        <div>
            <div class="payment__thought clearfix">
                <div class="row">
                    <div class="pull-left col-sm-4">
                        <p class="fs-18">Chọn thanh toán qua:</p>
                        <p class="fs-24 color-00898e">Thẻ ATM</p>
                    </div>
                    <div class="col-sm-8 text-right">
                        <div class="frm__item frm__code--promo">
                            <label for="">Mã khuyến mại</label>
                            <input placeholder="Vd: HAPPYBOOK69" type="text">
                            <button class="btn__apply">Áp dụng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="payment__infor--block">
                <p class="fs-16 font-700 mgB-5">Chọn ngân hàng</p>
                <p class="fs-16">Gợi ý: Chọn ngân hàng đang có mức ưu đãi để giảm chi phí</p>
                <div class="payment__content slect__banks">
                    <ul class="clearfix payment__banks">
                        <li>
                            <a class="active">
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-vietcombank.png') }}">
                                </div>
                                <p class="fst-i">-không có ưu đã-</p>
                            </a>
                        </li>
                        <li class="has__bonus">
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-anz.png') }}">
                                </div>
                                <span class="percent__bonus">Giảm 0,8%</span>
                                <p class="font-700">3,1600,000VNĐ</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-vietcombank.png') }}">
                                </div>
                                <p class="fst-i">-không có ưu đã-</p>
                            </a>
                        </li>
                        <li class="has__bonus">
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-vietcombank.png') }}">
                                </div>
                                <span class="percent__bonus">Giảm 0,8%</span>
                                <p class="font-700">3,1600,000VNĐ</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-vietin.png') }}">
                                </div>
                                <p class="fst-i">-không có ưu đã-</p>
                            </a>
                        </li>
                        <li class="has__bonus">
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-donga.png') }}">
                                </div>
                                <span class="percent__bonus">Giảm 0,8%</span>
                                <p class="font-700">3,1600,000VNĐ</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-vietcombank.png') }}">
                                </div>
                                <p class="fst-i">-không có ưu đã-</p>
                            </a>
                        </li>
                        <li class="has__bonus">
                            <a>
                                <div class="logo__wrap">
                                    <img alt="" src="{{ url('/logo-vietcombank.png') }}">
                                </div>
                                <span class="percent__bonus">Giảm 0,8%</span>
                                <p class="font-700">3,1600,000VNĐ</p>
                            </a>
                        </li>
                    </ul>
                    <div class="payment__content--bottom">
                        <div class="text-right">
                            <form class="form-horizontal ng-untouched ng-pristine ng-valid" action="#"
                                  id="debit-napas-form" method="post">
                                <button class="payment__btn">Thanh toán</button>
                            </form>
                            <p class="mgT-15">Bằng việc nhấn nút <a class="font-500 link__hover--default">Thanh toán</a>,
                                bạn đồng ý <a class="font-500 link__hover--default">Điều khoản &amp; Điều kiện</a> và <a
                                        class="font-500 link__hover--default">Chính sách quyền riêng tư</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="sidebar__payment sidebar__time">
            <div class="sidebar__time--top">
                <span class="icons icon-time"></span>
                <p class="fs-16 font-700">Thời gian thanh toán</p>
                <timer ng-reflect-time-in-seconds="86343">
                    <div>
                        <div>23 giờ 51 phút 05 giây</div>
                    </div>
                </timer>
            </div>
            <div class="sidebar__time--bottom">
                <p class="text-center fs-12"><span class="font-500">Lưu ý:</span> Giao dịch sẽ hủy khi hết thời gian
                    thanh toán</p>
            </div>
        </div>
        <div class="sidebar__payment sidebar__checkticket">
            <div class="title">Kiểm tra vé máy bay</div>
            <div class="checkticket__item ng-tns-c12-7">
                <div class="clearfix mgB-10">
                    <img class="left mgR-10" alt="" width="42px" src="./Viettel Booking_files/1501606022.3.jpg">
                    <div class="overflow-all">
                        <p class="fs-12 font-500">Chuyến bay đi: </p>
                        <p class="fs-12">Thứ Hai, 31 tháng 7, 2017</p>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="time__locaton">
                        <p class="fs-18 font-500 text-overflow">HAN | 6:00 AM</p>
                    </div>
                    <div class="line__detail">
                        <p class="fs-12 font-300">0 điểm dừng</p>
                        <div class="line">
                            <span class="dot__left"></span>
                            <span class="dot__right"></span>
                        </div>

                    </div>
                    <div class="time__locaton">
                        <p class="fs-18 font-500 text-overflow">SGN | 8:05 AM</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__payment pay__total--price">
            <div class="title">Thông tin giá</div>
            <div class="sidebar__inner">
                <div class="clearfix mgB-20 ng-tns-c12-7">
                    <p class="left fs-16">Chuyến bay đi</p>
                    <p class="right fs-16">1,103,000 VNĐ</p>
                </div>
            </div>
            <div class="clearfix sidebar__bottom">
                <p class="left fs-18 font-700">Giảm trừ</p>
                <p class="fs-18 right"><span class="color-00898e d-ib mgR-5 font-700">0</span>VNĐ</p>
            </div>
            <div class="clearfix sidebar__bottom">
                <p class="left fs-18 font-700">Total</p>
                <p class="fs-18 right"><span class="color-00898e d-ib mgR-5 font-700">1,103,000</span>VNĐ</p>
            </div>
        </div>
    </div>
</div>