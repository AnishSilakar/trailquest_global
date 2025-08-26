<?php

namespace Modules\Core\Admin;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\AdminController;
use Modules\Core\Models\Quiz;
use Modules\Core\Models\MenuTranslation;
use Modules\Core\Models\QuizQuestions;
use Modules\News\Models\NewsCategory;
use Modules\Page\Models\Template;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\QuizQuestionAnswers;
use Modules\Core\Models\QuizSubmission;
use Modules\Core\Models\QuizSubmissionAnswers;
use Illuminate\Support\Facades\DB;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourCategory;

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

    public function getFirst()
    {
        return Quiz::with('questions', 'questions.answers')->offset(0)->limit(1)->get();
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
            'questions.*' => [
                function ($attribute, $value, $fail) {
                    $hasAnswers = !empty($value['answers']) && is_array($value['answers']) && count($value['answers']) > 0;
                    $hasParagraph = !empty($value['paragraph']);
                    $hasRange = isset($value['range_min']) && isset($value['range_max']) && $value['range_min'] !== null && $value['range_max'] !== null;
                    if (!$hasAnswers && !$hasParagraph && !$hasRange) {
                        $fail("Each question must have either answers, a paragraph, or both range_min and range_max.");
                    }
                }
            ],
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->route('core.admin.quiz.index')->with('success', __('Quiz Error!'));
        }

        $this->updateOrStore($data, $request);

        return redirect()->route('core.admin.quiz.index')->with('success', __('Quiz created successfully!'));
    }

    public function updateOrStore($data, $request)
    {
        $icon = '';
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $icon = $file->store('0000/quizzes', 'uploads') ?? '';
        }
        $quiz = Quiz::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'oneliner' => $data['oneliner'],
            'icon' => $icon,
            // 'buttonTxt' => $data['buttonTxt']
        ]);
        foreach ($data['questions'] as $index => $question) {
            $newIcon = '';
            if ($request->hasFile("questions.$index.icon")) {
                $file = $request->file("questions.$index.icon");
                $newIcon = $file->store('0000/quizzes', 'uploads') ?? '';
            }
            $quiz_questions = QuizQuestions::create([
                'core_quiz_id' => $quiz->id,
                'questions' => $question['question'],
                'type' => $question['type'],
                'affect_result' => isset($question['affect_result']) ? 1 : 0,
                'oneliner' => $question['oneliner'],
                'onelinerFooter' => $question['onelinerFooter'],
                'icon' => $newIcon

            ]);
            if ($question['type'] == 'paragraph') {
                // Store paragraph or print it as needed
                // Example: save as a special answer type
                QuizQuestionAnswers::create([
                    'paragraph' => $question['paragraph'],
                    'is_correct' => 0,
                    'core_quiz_questions_id' => $quiz_questions->id,
                ]);
            } elseif ($question['type'] == 'range') {
                // Insert range_min and range_max if present
                if (isset($question['range_min']) && isset($question['range_max'])) {
                    QuizQuestionAnswers::create([
                        'range_min' => $question['range_min'],
                        'range_max' => $question['range_max'],
                        'is_correct' => 0,
                        'core_quiz_questions_id' => $quiz_questions->id,
                    ]);
                }
            } else {
                foreach ($question['answers'] as $answer) {
                    QuizQuestionAnswers::create([
                        'answers' => $answer,
                        'is_correct' =>  0,
                        'core_quiz_questions_id' => $quiz_questions->id,
                    ]);
                }
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

    public function submitQuiz(Request $request)
    {
        $data = $request->all();
        // Validate input
        $validator = Validator::make($data, [
            'answers' => 'required|array',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'answers' => json_encode($data['answers']),
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
        ];

        $data['quiz_id'] = $this->getFirst()->first()->id ?? null;
        $quizSubmission =  QuizSubmission::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'quiz_id' => $data['quiz_id'],
            'result' => "",
        ]);


        $data = json_decode($data['answers'], true);

        // Loop through the associative array
        $rangeQuestion = QuizQuestions::where('type', 'range')->pluck('id')->toArray();

        // Get id of price range question
        $lastQuestion = optional(QuizQuestions::where('core_quiz_id', $quizSubmission['quiz_id'])
                        ->orderBy('id', 'desc') // or 'created_at', depending on your table
                        ->first())->id;
        $result = [];
       if (array_key_exists($lastQuestion, $data)) {
            $value = $data[$lastQuestion];
           // loop here and get price range
            $opionsData = QuizQuestionAnswers::where('core_quiz_questions_id', $lastQuestion)->get();
            $selectPrice = $opionsData[$value];
           $resValue = $this->getMinMaxPrice($selectPrice->answers);
        } else {
            echo "Key 20 does not exist.";
        }
        $result = $this->logicForResult($data, $rangeQuestion, $resValue['min'], $resValue['max']);
        //store the result in quiz_submission
        $quizSubmission->result = json_encode($result);
        $quizSubmission->save();

        foreach ($data as $key => $value) {
            $insertData = [
                'question_id' => $key,
                'answers_id' => null, // Default to null, will be set if answer is not a range
                'quiz_submission_id' => $quizSubmission->id,
                'range_value' => null, // Default to null, will be set if answer is a range
            ];
            if (in_array($key, $rangeQuestion)) {
                $insertData['range_value'] = $value; // Set the range value
            } else {
                $answers = QuizQuestionAnswers::where('core_quiz_questions_id', $key)->get();
                $insertData['answers_id'] = $answers[$value]->id;
            }
            QuizSubmissionAnswers::create($insertData);
        }
        // send mail
        try {
            Mail::to('anishsilakar5@gmail.com')->send(new ContactFormMail([
                'name' => $quizSubmission['name'],
                'email' => $quizSubmission['email'],
                'phone' => $quizSubmission['contact'],
            ]));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        return response()->json(['result' => $result]);
    }

    public function getMinMaxPrice($selectedOption){
        $min = null;
        $max = null;

        // Extract all numbers
        preg_match_all('/\d+/', $selectedOption, $matches);
        $prices = array_map('intval', $matches[0]);

        if (stripos($selectedOption, 'Above') !== false && count($prices) >= 1) {
            $min = $prices[0];
            $max = null; // open-ended upper range
        } elseif (count($prices) === 2) {
            [$min, $max] = $prices;
        } elseif (count($prices) === 1) {
            $min = $prices[0];
            $max = $prices[0]; // single fixed value
        }
       return $afterValue = [ 'min' => $min, 'max' => $max];
    }

    public function logicForResult($firstArray, $secondArray, $min, $max)
    {
        $comparedArray = array_filter(
            $firstArray,
            function ($value, $key) use ($secondArray) {
                return !in_array($key, $secondArray);
            },
            ARRAY_FILTER_USE_BOTH
        );

        // Logics to filter based on affect_result or not
        $newArray = [];
        foreach ($comparedArray as $key => $value) {
            $check = QuizQuestions::where('id', $key)->first();
            if ($check && $check->affect_result) {
                $newArray[$key] = $value;
            }
        }

        // Count the frequency of each value
        $frequency = array_count_values($newArray);

        // Find the value with the highest repetition
        $maxCount = max($frequency);
        $mostRepeatedValues = array_keys($frequency, $maxCount);

        // Assuming you want the first most repeated value if multiple tied
        $mostRepeatedValue = $mostRepeatedValues[0];

        // Print message based on the most repeated value
        $type = "";
        $element = "";
        $focus = "";
        $message = "";
        $group = "";
        switch ($mostRepeatedValue) {
            case 0:
                $type = "The Daring"; //Push Your Limits
                $group = "Push Your Limits";
                $element = "&#x1F525;"; // Fire emoji
                $focus = "You Burn Bright.";
                $message = " You’re wired for challenge. The steeper the climb, the stronger your will. You don’t just push limits—you redefine them. You’re here to rise, to roar, and to lead the charge. This is your moment. Take the leap.";
                break;
            case 1:
                $type = "The Dreamer"; //Reconnect with Nature
                $group = "Reconnect With Nature";
                $element = "&#x1F4A8;"; // Wind emoji
                $focus = "You Breathe Possibility.";
                $message = " Your soul drifts where the wild wind calls. You’re drawn to open skies, quiet trails, and the kind of silence that speaks. You move lightly but think deeply. For you, every step is a chance to imagine more. So go where you feel most free.";
                break;
            case 2:
                $type = "The Grounded"; //Declutter Your Mind
                $group = "Declutter Your Mind";
                $element = "&#x1F30E;"; // Earth emoji
                $focus = "You don’t rush. You root.";
                $message = " When the world spins fast, you slow things down. You find strength in stillness and clarity in the quiet. You’re grounded, steady, and real. The noise out there? It doesn’t shake you. You know your pace. And you trust your path.";
                break;
            case 3:
                $type = "The Rebel"; // Explore the Ancient
                $group = "Explore The Ancients";
                $element = "&#x1F30A;"; // Water emoji
                $focus = "You Flow Your Own Way.";
                $message = " Rules? You rewrite them. Paths? You carve your own. You’re fluid, fearless, and full of surprise. Adventure isn’t a plan—it’s a feeling. You trust your gut, ride the current, and dive deep when others stay shallow. Stay wild.";
                break;
            default:
                break;
        }
        $tours = $this->getTours($group, $min, $max);
        return [
            'type' => $type,
            'element' => $element,
            'focus' => $focus,
            'message' => $message,
            'tours' => $tours,
        ];
    }

    public function getTours($group , $min, $max)
    {
        // dd($min, $max);
        $mainCategory = DB::table('bravo_tour_category as btc')
            ->join('bravo_tour_category as bt', 'bt.id', '=', 'btc.parent_id')
            ->whereNotNull('btc.parent_id')
            ->where('btc.status', 'Publish')
            ->where('bt.name', $group)
            ->whereNull('btc.deleted_at')
            ->select(DB::raw('DISTINCT btc.parent_id'), 'bt.name')
            ->groupBy('btc.parent_id', 'bt.name') // include bt.name in groupBy to avoid SQL errors in strict mode
            ->first();
        $id = $mainCategory->parent_id ?? null;
        $subCategories = TourCategory::where('parent_id', $id)
            ->where('status', 'Publish')
            ->whereNull('deleted_at')
            ->get();
        $tours = [];
        if ($subCategories->isNotEmpty()) {
            foreach ($subCategories as $subCategory) {
                $tourQuery = Tour::where('category_id', $subCategory->id)
                    ->where('status', 'Publish')
                    ->whereNull('deleted_at')
                    ->where('sale_price', '>', $min);

                if (!is_null($max)) {
                    $tourQuery->where('sale_price', '<', $max);
                }

                $tourResult = $tourQuery->inRandomOrder()->first();
                if ($tourResult) {
                    $tours[] = [
                        'id' => $tourResult->id,
                        'title' => $tourResult->title,
                        'slug' => $tourResult->slug,
                        'image' => get_file_url($tourResult->image_id, 'full'),
                        'category_name' => $subCategory->name,
                        'sale_price' => $tourResult->sale_price, 
                        'duration' => $tourResult->duration
                    ];
                }
            }
        }
        return $tours;
    }
}
