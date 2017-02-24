# Eloquent Searcher

## Usage

Create searcher class.

```php
namespace App\Searchers;

use EloquentSearcher\Searcher;

class UserSearcher extends Searcher
{
    protected $searchFields = [
        'group.name' => Searcher::EQUALS,
        'name' => Searcher::CONTAINS,
        'is_active' => Searcher::IS_TRUE,
        'created_at' => Searcher::DATE_RANGE,
        'project' => 'searchProject',
    ];

    protected $keywordFields = [
        'group.name' => Searcher::EQUALS,
        'name' => Searcher::CONTAINS,
        'notes' => Searcher::CONTAINS,
    ];

    protected function searchProject($query, $field, $value)
    {
        return $query->whereHas('projects', function ($query) use ($value) {
            return $query->where('projects', $value);
        });
    }
}
```

Implement searcher trait into your model.

```php
namespace App\Models;

use EloquentSearcher\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

use App\Searchers\UserSearcher;

class User extends Model
{
    use SearchableTrait;

    protected $searcher = UserSearcher::class;
    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'is_active',
        'notes',
    ];

    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
```

And use it.

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $conditions = $request->all();
        // $conditions = [
        //     'keyword' => 'programmer',
        //     'group' => [
        //         'name' => 'Employee',
        //     ],
        //     'name' => 'James',
        //     'project' => 'Impressive Project',
        //     'is_active' => true,
        //     'created_at' => [
        //         'from' => '2016-01-01',
        //         'until' => '2016-12-31',
        //     ],
        // ];
        $users = User::search($conditions);
        return view('index', ['users' => $users]);
    }
}
```


## Builtin Rules

* Searcher::EQUALS
* Searcher::CONTAINS
* Searcher::STARTSWITH
* Searcher::ENDSWITH
* Searcher::GT
* Searcher::GTE
* Searcher::LT
* Searcher::LTE
* Searcher::RANGE
* Searcher::DATE_RANGE
* Searcher::DATETIME_RANGE
* Searcher::IN
* Searcher::IS_NULL
* Searcher::IS_NOT_NULL
* Searcher::IS_TRUE
* Searcher::IS_NOT_TRUE
* Searcher::IS_FALSE
* Searcher::IS_NOT_FALSE
