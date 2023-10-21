<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Group;
use App\Models\Mark;
use App\Models\Parameter;
use App\Models\Part;
use App\Models\Unit;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function store(Request $request)
    {

        $content = $request->getContent();
        $data = json_decode($content, true);

        $markName = $data['mark'];
        $parameters = $data['parameters'];
        $carName = $data['car_name'];
        $categoryNames = $data['categories'];
        $groupedDetails = $data['grouped_details'];

        if (count($categoryNames) == 0 || !$groupedDetails || !$markName || !$parameters || !$carName) {

            return response()->json(['success' => false]);

        }

        $mark = Mark::updateOrCreate(['name' => $markName], []);

        $optionIds = [];
        foreach ($parameters as $item) {
            $parameter = Parameter::updateOrCreate(['name' => $item['param']], []);
            $option = $parameter->options()->updateOrCreate(['name' => $item['option']], []);
            array_push($optionIds, $option->id);
        }

        $vehicle = $mark->vehicles()->where('name', $carName)->whereHas('options', function ($que) use ($optionIds) {
            $que->whereIn('options.id', $optionIds);
        }, '=', count($optionIds))->first();

        if (!$vehicle) {
            $vehicle = $mark->vehicles()->create([
                'name' => $carName,
            ]);
            $vehicle->options()->sync($optionIds);
            $vehicle->save();
        }

        $categoryNames = array_reverse($categoryNames);

        $parentCategory = null;

        foreach ($categoryNames as $categoryName) {
            $category = Category::updateOrCreate(
                [
                    'name' => $categoryName,
                    'parent_id' => $parentCategory,
                ],
                [
                ]
            );

            $parentCategory = $category->id;
        }

        if (!$category) {
            return response()->json(['success' => 'false asdadsa']);
        }

        foreach ($groupedDetails as $item) {

            $groupName = $item['name'];
            $unitsArray = $item['units'];

            $group = Group::updateOrCreate([
                'name' => $groupName,
            ], []);


            foreach ($unitsArray as $item) {
                $unit = $group->units()->updateOrCreate([
                    'name' => $item['name']
                ], []);

                $partsArray = $item['details'];

                foreach ($partsArray as $item) {
                    $part = Part::updateOrCreate([
                        'name' => $item['name'],
                        'oem' => $item['oem'],
                    ], [
                        'pnc' => $item['pnc'],
                        'note' => $item['note']
                    ]);
                }

                $unit->parts()->syncWithoutDetaching([$part->id]);
                $category->parts()->syncWithoutDetaching([$part->id]);
            }
        }





        // $vehicle = Vehicle::updateOrCreate([
        //     'name' => $carName,

        // ]);

        // dd($mark);

        return response()->json(['success' => true]);

    }
}