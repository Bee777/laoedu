<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/10/2019
 * Time: 5:22 PM
 */

namespace App\Responses;


use App\Http\Controllers\Helpers\Helpers;
use App\OrganizeChartMember;
use App\OrganizeChartRange;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class OrganizeChartMemberResponse implements Responsable
{

    protected $actionType = 'get';
    protected $options = [];

    public function __construct($actionType, $options = [])
    {
        $this->options = $options;
        $this->actionType = $actionType;
    }

    public function getFirstChart($request)
    {
        $data = null;
        $firstChart = OrganizeChartRange::select('organize_chart_ranges.*')->join('organize_chart_members', 'organize_chart_members.organize_chart_range_id', 'organize_chart_ranges.id')->groupBy('organize_chart_members.organize_chart_range_id')->orderBy('organize_chart_ranges.position_order', 'desc')->first();
        if (isset($firstChart)) {
            $this->options['text'] = '';
            $this->options['id'] = $firstChart->id;
            $data = $this->get($request);
        }
        return $data;
    }

    /**
     * Create an HTTP response that represents the object.
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function get(Request $request): array
    {
        $fields = ['id', 'name', 'position_order', 'university', 'company', 'image', 'surname', 'position', 'organize_chart_range_id', 'created_at', 'updated_at'];
        $request->request->add(['fields' => $fields]);
        $text = $this->options['text'];
        $data = OrganizeChartMember::select($fields)->where('organize_chart_range_id', $this->options['id']);
        $data->where(function ($query) use ($request, $text) {
            foreach ($request->fields as $k => $f) {
                if ($f === 'created_at' || $f === 'updated_at') {
                    if (Helpers::isEngText($text)) {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    } else {
                        continue;
                    }
                }
                $query->orWhere($f, 'LIKE', "%{$text}%");
            }
        });
        $data = $data->orderBy('position_order', 'desc')->get();
        $data->map(function ($d) {
            $d->image = OrganizeChartMember::$uploadPath . $d->image;
            $d->position_text = title_case($d->position);
            $d->image_base64 = '';
            return $d;
        });

        $president = $this->membersFilter($data, 'president');
        $vice_president = $this->membersFilter($data, 'vice_president');
        $committee = $this->membersFilter($data, 'committee');
        $other = $data->filter(function ($item) {
            return $item->position !== 'president' && $item->position !== 'vice_president'
                && $item->position !== 'committee';
        })->values();

        return [
            'success' => true,
            'selectedRange' => OrganizeChartRange::find($this->options['id']),
            'chartRanges' => OrganizeChartRange::getDesc(true),
            'data' => $committee->merge($other),
            'president' => count($president) > 0 ? $president[0] : null,
            'vice_president' => $vice_president,
            'committee' => $committee,
            'other' => $other,
        ];
    }

    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            $oldCount = OrganizeChartMember::all()->count();
            $position_order = $request->get('position_order');
            if ($this->actionType === 'insert') {
                #Image
                $uploadPath = OrganizeChartMember::$uploadPath;
                $file = $request->file('image');
                $img_filename = Helpers::upLoadImage($file, $uploadPath, 'member');
                #Image
                $info = OrganizeChartMember::create([
                    'image' => $img_filename,
                    'name' => $request->get('name'),
                    'surname' => $request->get('last_name'),
                    'university' => $request->get('university'),
                    'company' => $request->get('company'),
                    'position' => $this->getPosition($request),
                    'organize_chart_range_id' => $this->getChartRangeId($request),
                    'position_order' => $position_order ?? $oldCount + 1,
                ]);
                $data = $info;
            } else if ($this->actionType === 'update') {
                $info = OrganizeChartMember::find($request->id);
                if (isset($info)) {
                    #Image
                    $img_filename = null;
                    if ($request->hasFile('image')) {
                        $uploadPath = OrganizeChartMember::$uploadPath;
                        $file = $request->file('image');
                        $img_filename = Helpers::upLoadImage($file, $uploadPath, 'member');
                        Helpers::removeFile($uploadPath . $info->image);
                    }
                    #Image
                    OrganizeChartMember::where('id', $request->id)->update([
                        'image' => $img_filename ?? $info->image,
                        'name' => $request->get('name'),
                        'surname' => $request->get('last_name'),
                        'university' => $request->get('university'),
                        'company' => $request->get('company'),
                        'position' => $info->position === 'president' && $request->get('position') === 'president'
                            ? $info->position : $this->getPosition($request),
//                        'organize_chart_range_id' => $this->getChartRangeId($request),
                        'position_order' => $position_order ?? $oldCount + 1,
                    ]);
                    $data = $info;
                }
            } else if ($this->actionType === 'delete') {
                $info = OrganizeChartMember::find($request->id);
                if (isset($info)) {
                    Helpers::removeFile(OrganizeChartMember::$uploadPath . $info->image);
                    $info->delete();
                    $data = $info;
                }
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function getChartRangeId($request)
    {
        $id = $request->get('chart_range');
        $data = OrganizeChartRange::find($id);
        if (isset($data)) {
            return $id;
        }
        return 1;
    }

    public function membersFilter($data, $position)
    {
        return $data->filter(function ($item) use ($position) {
            return $item->position === $position;
        })->values();
    }

    public function getPresidentMember($range_id)
    {
        return OrganizeChartMember::where('organize_chart_range_id', $range_id)->where('position', 'president')->first();
    }

    public function getPosition($request)
    {
        $position = $request->get('position');
        $exits = ['president', 'vice_president', 'committee', 'other'];
        if (in_array($position, $exits, true)) {
            if ($position === 'other') {
                $position = $request->get('other_position');
            }
            if ($position === 'president') {
                $presidentMember = $this->getPresidentMember($request->get('chart_range'));
                if (isset($presidentMember)) {
                    $position = 'vice_president';
                }
            }
        } else {
            $position = 'No position.';
        }
        $position = $position ?? 'No position';
        return $position;
    }
}
