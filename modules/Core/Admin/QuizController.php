<?php

namespace Modules\Core\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Core\Models\Quiz;
use Modules\Core\Models\MenuTranslation;
use Modules\Core\Models\QuizQuestions;
use Modules\News\Models\NewsCategory;
use Modules\Page\Models\Template;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\QuizQuestionAnswers;

class QuizController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu(route('core.admin.menu.index'));
    }

    public function index()
    {

        $this->checkPermission('quiz_view');
        $data = [
            'rows'           => Quiz::paginate(20),
        ];
        return view('Core::admin.quiz.index', $data);
    }

    public function getLocations()
    {
        return [
            'primary' => __("Primary"),
            //            'footer'  => __("Footer"),
        ];
    }

    public function create()
    {
        // $this->checkPermission('quiz_create');

        $data = [
            'breadcrumbs'            => [
                [
                    'name' => __('Quiz'),
                    'url'  => route('core.admin.quiz.index')
                ],
                [
                    'name'  => __('Create new quiz'),
                    'class' => 'active'
                ],
            ],
        ];
        return view('Core::admin.quiz.detail', $data);
    }

    public function edit($id)
    {

        $this->checkPermission('menu_update');
        $row = Quiz::with('questions', 'questions.answers')->find($id);
        if (empty($row)) {
            abort(404);
        }

        $data = [
            'quiz'  => $row,
            'breadcrumbs'  => [
                [
                    'name' => __('Menus'),
                    'url'  => route('core.admin.quiz.index')
                ],
                [
                    'name'  => __('Edit: ') . $row->name,
                    'class' => 'active'
                ],
            ],
        ];
        return view('Core::admin.quiz.detail', $data);
    }

    public function show($id)
    {
        // $this->checkPermission('quiz_view');
        $row = Quiz::with('questions', 'questions.answers')->find($id);
        if (empty($row)) {
            abort(404);
        }
        $data = [
            'quiz' => $row,
            'breadcrumbs' => [
                [
                    'name' => __('Quiz'),
                    'url'  => route('core.admin.quiz.index')
                ],
                [
                    'name'  => __('Detail: ') . $row->title,
                    'class' => 'active'
                ],
            ],
        ];
        return view('Core::admin.quiz.view', $data);
    }

    public function update(Request $request, $id)
    {

        // $this->checkPermission('quiz_update');
        $row = Quiz::find($id);
        if (empty($row)) {
            return redirect()->back()->with('error', __('Quiz not found!'));
        }
        $row->delete();
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array|min:2',
        ];
        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->route('core.admin.quiz.index')->with('success', __('Quiz Validation Error!'));
        }
        $this->updateOrStore($data);
        return redirect()->route('core.admin.quiz.index')->with('success', __('Quiz updated successfully!'));
    }

    public function searchTypeItems(Request $request)
    {

        $class = $request->input('class');
        $q = $request->input('q');
        if (class_exists($class) and method_exists($class, 'searchForMenu')) {

            $menuItems = call_user_func([
                $class,
                'searchForMenu'
            ], $q);

            foreach ($menuItems as $k => &$menuItem) {
                $menuItem['class'] = '';
                $menuItem['target'] = '';
                $menuItem['open'] = false;
                $menuItem['item_model'] = $class;
                $menuItem['origin_name'] = $menuItem['name'];
                $menuItem['model_name'] = $class::getModelName();
            }

            return $this->sendSuccess([
                'data' => $menuItems
            ]);
        }
        return $this->sendSuccess([
            'data' => []
        ]);
    }

    public function getTypes()
    {
        $menuModels = [
            [
                'class' => \Modules\Page\Models\Page::class,
                'name'  => __("Page"),
                'items' => \Modules\Page\Models\Page::searchForMenu(),
                'position' => 10
            ],
            [
                'class' => \Modules\Location\Models\Location::class,
                'name'  => __("Location"),
                'items' => \Modules\Location\Models\Location::searchForMenu(),
                'position' => 40
            ],
            [
                'class' => \Modules\News\Models\News::class,
                'name'  => __("News"),
                'items' => \Modules\News\Models\News::searchForMenu(),
                'position' => 50
            ],
            [
                'class' => NewsCategory::class,
                'name'  => __("News Category"),
                'items' => NewsCategory::searchForMenu(),
                'position' => 60
            ],
        ];

        // Modules
        $custom_modules = \Modules\ServiceProvider::getActivatedModules();
        if (!empty($custom_modules)) {
            foreach ($custom_modules as $module) {
                $moduleClass = $module['class'];
                if (class_exists($moduleClass)) {
                    $menuConfig = call_user_func([$moduleClass, 'getMenuBuilderTypes']);

                    if (!empty($menuConfig)) {
                        $menuModels = array_merge($menuModels, $menuConfig);
                    }
                }
            }
        }
        // Plugins Menu
        $plugins_modules = \Plugins\ServiceProvider::getModules();
        if (!empty($plugins_modules)) {
            foreach ($plugins_modules as $module) {
                $moduleClass = "\\Plugins\\" . ucfirst($module) . "\\ModuleProvider";
                if (class_exists($moduleClass)) {
                    $menuConfig = call_user_func([$moduleClass, 'getMenuBuilderTypes']);
                    if (!empty($menuConfig)) {
                        $menuModels = array_merge($menuModels, $menuConfig);
                    }
                }
            }
        }

        $menuModels = array_values(\Illuminate\Support\Arr::sort($menuModels, function ($value) {
            return $value['position'] ?? 100;
        }));
        foreach ($menuModels as $k => &$item) {
            $item['q'] = '';
            $item['open'] = !$k ? true : false;
            $item['selected'] = [];
            if (!empty($item['items'])) {
                foreach ($item['items'] as &$menuItem) {
                    $menuItem['class'] = '';
                    $menuItem['target'] = '';
                    $menuItem['open'] = false;
                    $menuItem['item_model'] = $item['class'];
                    $menuItem['origin_name'] = $item['name'];
                    $menuItem['model_name'] = $item['class']::getModelName();
                }
            }
        }
        return $this->sendSuccess(['data' => $menuModels]);
    }

    public function getItems(Request $request)
    {

        $menu = Quiz::find($request->input('id'));
        if (empty($menu))
            return $this->sendError(__("Menu not found"));
        return $this->sendSuccess(['data' => json_decode($menu->items, true)]);
    }

    public function store(Request $request)
    {
        //     // $this->checkPermission('quiz_create');
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array|min:2',
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->route('core.admin.quiz.index')->with('success', __('Quiz Error!'));
        }

        $this->updateOrStore($data);

        return redirect()->route('core.admin.quiz.index')->with('success', __('Quiz created successfully!'));
    }

    public function updateOrStore($data)
    {
        $quiz = Quiz::create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        foreach ($data['questions'] as $question) {
            $quiz_questions = QuizQuestions::create([
                'core_quiz_id' => $quiz->id,
                'questions' => $question['question'],
            ]);
            foreach ($question['answers'] as $answer) {
                QuizQuestionAnswers::create([
                    'answers' => $answer,
                    'is_correct' =>  0,
                    'core_quiz_questions_id' => $quiz_questions->id,
                ]);
            }
        }
        return $quiz;
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }

        switch ($action) {
            case "delete":
                foreach ($ids as $id) {
                    $query = Quiz::where("id", $id);
                    $query->where("create_user", Auth::id());
//                    if (!$this->hasPermission('menu_update')) {
//                        $query->where("create_user", Auth::id());
//                        $this->checkPermission('menu_delete');
//                    }
                    $row = $query->first();
                    if (!empty($row)) {
                        $row->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
        }
    }
}
