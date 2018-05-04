<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const DTV_ROLE = 'dtv';

    const PERMISSION_GROUPS = [
        'NGƯỜI DÙNG' => [
            'u1' => 'Xem danh sách',
            'u2' => 'Chỉnh sửa',
            'u3' => 'Xem quyền',
            'u4' => 'Quản lý quyền'
        ],
        'TIN TỨC' => [
            'n1' => 'Xem tin tức',
            'n2' => 'Sửa tin tức',
            'n3' => 'Xem mục tin',
            'n4' => 'Sửa mục tin'
        ],
        'BÁO CÁO' => [
            'r1' => 'Xem báo cáo',
            'r2' => 'Tải file excel'
        ],
        'FAQs' => [
            'q1' => 'Xem câu hỏi',
            'q2' => 'Sửa câu hỏi',
            'q3' => 'Xem danh mục',
            'q4' => 'Sửa danh mục'
        ],
        'THÔNG BÁO' => [
            't1' => 'Xem thông báo',
            't2' => 'Sửa thông báo'
        ],
        'KHẢO SÁT' => [
            'v1' => 'Xem khảo sát',
            'v2' => 'Sửa khảo sát'
        ],
        'KHUYẾN MÃI' => [
            'p1' => 'Xem khuyến mãi',
            'p2' => 'Sửa khuyến mãi',
            'p3' => 'Xem ngân hàng liên kết',
            'p4' => 'Sửa ngân hàng liên kết',
            'p5' => 'Xem đối tác liên kết',
            'p6' => 'Sửa đối tác liên kết',
            'p7' => 'Xem nhóm đối tác',
            'p8' => 'Sửa nhóm đối tác'
        ],
        'VÉ MÁY BAY' => [
            'f1' => 'Xem danh sách đặt chỗ',
            'f2' => 'Thao tác trên booking',
            'f3' => 'Xem sân bay',
            'f4' => 'Sửa sân bay',
            'f5' => 'Xem hãng hàng không',
            'f6' => 'Sửa hãng hàng không',
            'f7' => 'Xem chuyến bay phổ biến',
            'f8' => 'Sửa chuyến bay phổ biến'
        ],
        'HỆ THỐNG' => [
            's1' => 'Xem cấu hình',
            's2' => 'Sửa cấu hình',
            's3' => 'Xem log hệ thống'
        ],
    ];

    const PERMISSIONS = [
        'FLIGHT_BOOKINGS_VIEW'      => 'f1',
        'FLIGHT_BOOKINGS_MANAGE'   => 'f2',
        'AIRPORTS_VIEW'             => 'f3',
        'AIRPORTS_MANAGE'           => 'f4',
        'AIRLINES_VIEW'             => 'f5',
        'AIRLINES_MANAGE'           => 'f6',
        'TOP_FLIGHTS_VIEW'          => 'f7',
        'TOP_FLIGHTS_MANAGE'        => 'f8',
        'FAQS_VIEW'                 => 'q1',
        'FAQS_MANAGE'               => 'q2',
        'FAQS_CATEGORIES_VIEW'      => 'q3',
        'FAQS_CATEGORIES_MANAGE'    => 'q4',
        'NEWS_VIEW'                 => 'n1',
        'NEWS_MANAGE'               => 'n2',
        'NEWS_CATEGORIES_VIEW'      => 'n3',
        'NEWS_CATEGORIES_MANAGE'    => 'n4',
        'PROMOTIONS_VIEW'           => 'p1',
        'PROMOTIONS_MANAGE'         => 'p2',
        'PROMOTIONS_BANK_VIEW'      => 'p3',
        'PROMOTIONS_BANK_MANAGE'    => 'p4',
        'PARTNERS_VIEW'             => 'p5',
        'PARTNERS_MANAGE'           => 'p6',
        'PARTNER_GROUPS_VIEW'       => 'p7',
        'PARTNER_GROUPS_MANAGE'     => 'p8',
        'REPORT_VIEW'               => 'r1',
        'REPORT_DOWNLOAD'           => 'r2',
        'SYSTEM_VIEW'               => 's1',
        'SYSTEM_MANAGE'             => 's2',
        'SYSTEM_LOG'                => 's3',
        'NOTIFICATIONS_VIEW'        => 't1',
        'NOTIFICATIONS_MANAGE'      => 't2',
        'USERS_VIEW'                => 'u1',
        'USERS_MANAGE'              => 'u2',
        'ROLES_VIEW'                => 'u3',
        'ROLES_MANAGE'              => 'u4',
        'SURVEY_VIEW'               => 'v1',
        'SURVEY_MANAGE'             => 'v2',

    ];


    const CONTROLLERS = [
        'AirBookingsController' => [
            'index' => ['f1'],
            'show' => ['f1'],
            'transfer' => ['f2'],
            'commit' => ['f2'],
            'sendEmail' => ['f2'],
            'sendSMS' => ['f2']

        ],

        'AirportsController' => [
            'index' => ['f3'],
            'show' => ['f3'],
            'create' => ['f4'],
            'store' => ['f4'],
            'edit' => ['f4'],
            'update' => ['f4'],
            'destroy' => ['f4'],
            'importExcel' => ['f4']
        ],

        'AirlinesController' => [
            'index' => ['f5'],
            'show' => ['f5'],
            'create' => ['f6'],
            'store' => ['f6'],
            'edit' => ['f6'],
            'update' => ['f6'],
            'destroy' => ['f6'],
            'changeLogo' => ['f6'],
            'importExcel' => ['f6']
        ],

        'TopFlightsController' => [
            'index' => ['f7'],
            'show' => ['f7'],
            'create' => ['f8'],
            'store' => ['f8'],
            'edit' => ['f8'],
            'update' => ['f8'],
            'destroy' => ['f8'],
            'updateSequence' => ['f8']
        ],

        'FaqsController' => [
            'index' => ['q1', 'q3'],
            'show' => ['q1'],
            'create' => ['q2'],
            'store' => ['q2'],
            'edit' => ['q2'],
            'update' => ['q2'],
            'destroy' => ['q2']
        ],

        'FaqCategoriesController' => [
            'show' => ['q3'],
            'create' => ['q4'],
            'store' => ['q4'],
            'edit' => ['q4'],
            'update' => ['q4'],
            'destroy' => ['q4']
        ],

        'NewsController' => [
            'index' => ['n1', 'n3'],
            'show' => ['n1'],
            'create' => ['n2'],
            'store' => ['n2'],
            'edit' => ['n2'],
            'update' => ['n2'],
            'destroy' => ['n2'],
            'changeSubtitleImage' => ['n2']
        ],

        'NewsCategoriesController' => [
            'show' => ['n3'],
            'create' => ['n4'],
            'store' => ['n4'],
            'edit' => ['n4'],
            'update' => ['n4'],
            'destroy' => ['n4']
        ],

        'PromotionsController' => [
            'index' => ['p1'],
            'show' => ['p1'],
            'getHistory' => ['p1'],
            'getCodes' => ['p1'],
            'create' => ['p2'],
            'store' => ['p2'],
            'edit' => ['p2'],
            'update' => ['p2'],
            'destroy' => ['p2'],
            'importExcel' => ['p2'],
            'importPartnerExcel' => ['p2'],
            'changeImage' => ['p2'],
            'showSearchForm' => ['p2'],
            'searchUsers' => ['p2']
        ],

        'PromotionDeliveriesController' => [
            'store' => ['p2'],
            'destroy' => ['p2']
        ],

        'PromoBanksController' => [
            'index' => ['p3'],
            'show' => ['p3'],
            'create' => ['p4'],
            'store' => ['p4'],
            'edit' => ['p4'],
            'update' => ['p4'],
            'destroy' => ['p4'],
            'changeLogo' => ['p4']
        ],

        'PartnersController' => [
            'index' => ['p5', 'p7'],
            'show' => ['p5'],
            'create' => ['p6'],
            'store' => ['p6'],
            'edit' => ['p6'],
            'update' => ['p6'],
            'destroy' => ['p6']
        ],

        'PartnerGroupsController' => [
            'show' => ['p7'],
            'create' => ['p8'],
            'store' => ['p8'],
            'edit' => ['p8'],
            'update' => ['p8'],
            'destroy' => ['p8']
        ],

        'BusinessController' => [
            'business' => ['r1'],
            'exportExcel' => ['r2'],
            'crossCheck' => ['r1'],
        ],

        'ConfigurationsController' => [
            'index' => ['s1'],
            'update' => ['s2'],
            'sendTestEmail' => ['s2'],
            'sendTestHoldTicket' => ['s2'],
            'sendTestCommitTicket' => ['s2'],
            'sendTestSMS' => ['s2'],
            'formPayment' => ['s2'],
            'formPaymentResponse' => ['s2']
        ],

        'SurveysController' => [
            'index' => ['v1'],
            'show' => ['v1'],
            'create' => ['v2'],
            'store' => ['v2'],
            'edit' => ['v2'],
            'update' => ['v2'],
            'destroy' => ['v2']
        ],

        'SurveyQuestionsController' => [
            'show' => ['v1'],
            'create' => ['v2'],
            'store' => ['v2'],
            'edit' => ['v2'],
            'update' => ['v2'],
            'destroy' => ['v2']
        ],

        'SurveyAnswersController' => [
            'create' => ['v2'],
            'store' => ['v2'],
            'edit' => ['s2'],
            'update' => ['v2'],
            'destroy' => ['v2']
        ],


        'ActivityHistoriesController' => [
            'index' => ['s3']
        ],

        'NotificationsController' => [
            'index' => ['t1'],
            'show' => ['t1'],
            'transfer' => ['t2'],
            'commit' => ['t2'],
            'sendEmail' => ['t2'],
            'sendSMS' => ['t2']
        ],

        'UsersController' => [
            'index' => ['u1'],
            'dtvs' => ['u1'],
            'show' => ['u1'],
            'getUserBookingHistory' => ['u1'],
            'getUserPromotionHistory' => ['u1'],
            'edit' => ['u2'],
            'update' => ['u2'],
            'changeUserProfileImage' => ['u2']
        ],

        'RolesController' => [
            'index' => ['u3'],
            'show' => ['u3'],
            'create' => ['u4'],
            'store' => ['u4'],
            'edit' => ['u4'],
            'update' => ['u4'],
            'destroy' => ['u4']
        ],
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'permissions'];

    /**
     * Get the users of role.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
