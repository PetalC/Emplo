<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use App\Job\Transformers\EducationHQTransformer;
use App\Job\Transformers\IndeedTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advert extends Model
{
    use SoftDeletes;
    use Searchable;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_adverts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'position_type',
        'length',
        'description',
        'time_requirement',
        'experience_requirement',
        'minimum_salary',
        'maximum_salary',
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'start_date' => 'date:Y-m-d'
    ];

    /**
     * The attributes that are added to the collections.
     *
     * @var array
     */
    protected $appends = ['cost', 'short_description', 'slug_title'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array['id'] = $this->id;
        $array['title'] = $this->title;
        $array['position_type'] = $this->position_type;
        $array['length'] = $this->length;
        $array['description'] = $this->description;
        $array['time_requirement'] = $this->time_requirement;
        $array['experience_requirement'] = $this->liscensing_authority;
        $array['liscensing_authority'] = $this->liscensing_authority;
        $array['created_at'] = $this->created_at;
        $array['updated_at'] = $this->updated_at;
        $array['expires_at'] = $this->expires_at;

        $array['schoolName'] = $this->schoolDetails->name;
        $array['schoolCity'] = $this->schoolDetails->city;
        $array['schoolState'] = $this->schoolDetails->state;
        $array['schoolCountry'] = $this->schoolDetails->country;
        $array['schoolSector'] = $this->schoolDetails->classification;
        $array['_geoloc']['lat'] = (float)$this->schoolDetails->latitude;
        $array['_geoloc']['lng'] = (float)$this->schoolDetails->longitude;

        if ($this->campus > 0) {
            $array['schoolCity'] = $this->campusDetails->city;
            $array['schoolState'] = $this->campusDetails->state;
            $array['schoolCountry'] = $this->campusDetails->country;
            $array['_geoloc']['lat'] = (float)$this->campusDetails->latitude;
            $array['_geoloc']['lng'] = (float)$this->campusDetails->longitude;
        }

        $array['specializations'] = [];

        foreach ($this->specializations as $specialization) {
            $array['specializations'][] = $specialization->id;
        }

        return $array;
    }

    /**
     * The School advertising the Job
     *
     * @return Profile
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class );
    }

    /**
     * The School Campus advertising the Job
     *
     * @return Profile
     */
    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class );
    }

    /**
     * The School advertising the Job
     *
     * @return Profile
     */
//    public function schoolDetails(): BelongsTo
//    {
//        return $this->belongsTo(Profile::class, 'school');
//    }

    /**
     * Profile of the User
     *
     * @return Invoice
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'job');
    }

    /**
     * Skills required for the Job
     *
     * @return array
     */
    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany('App\Specialization\Models\Tag', 'job_specializations', 'job', 'tag')->withTimestamps();
    }

    /**
     * Candidates applying for the job
     *
     * @return array
     */
    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'job_candidates', 'job', 'user')
            ->withPivot(['rejected_at', 'withdrawn_at'])
            ->wherePivot('withdrawn_at', null)
            ->withTimestamps();
    }

    public function transformToEHQ()
    {
        $transformer = new EducationHQTransformer($this);
        return $transformer->transform();
    }

    public function transformToIndeed()
    {
        $transformer = new IndeedTransformer($this);
        return $transformer->transform();
    }

    /**
     * The Cost of the Job
     *
     * @return User
     */
    public function getCostAttribute()
    {
        $cost = 0;

        if ($this->is_posted_on_seek) {
            $cost += 100;
        }

        if ($this->is_posted_on_indeed) {
            $cost += 100;
        }

        if ($this->is_posted_on_ton) {
            $cost += 100;
        }

        if ($this->is_posted_on_ehq) {
            $cost += 100;
        }

        return $cost;
    }

    /**
     * The Cost of the Job
     *
     * @return User
     */
    public function getShortDescriptionAttribute()
    {
        $description = $this->description;
        $description = strip_tags($description);
        $description = html_entity_decode($description);
        $description = implode(' ', array_slice(explode(' ', $description), 0, 50));

        return $description;
    }

    /**
     * The Cost of the Job
     *
     * @return User
     */
    public function getSlugTitleAttribute()
    {
        $slug = trim($this->title);
        $slug = str_replace("'", '', $slug);
        $slug = str_replace("/", '', $slug);
        $slug = str_replace("-", '', $slug);
        $slug = str_replace(" ", '-', $slug);

        return $slug;
    }
}
