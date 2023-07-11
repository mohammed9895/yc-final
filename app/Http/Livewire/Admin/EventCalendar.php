<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Slot;
use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Asantibanez\LivewireCalendar\LivewireCalendar;

class EventCalendar extends Component
{
    public $events = '';

    public function getevent()
    {
        $events = Event::select('id', 'title', 'start')->get();

        return  json_encode($events);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addevent($event)
    {
        $input['title'] = $event['title'];
        $input['start'] = $event['start'];
        Event::create($input);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function eventDrop($event, $oldEvent)
    {
        $eventdata = Event::find($event['id']);
        $eventdata->start = $event['start'];
        $eventdata->save();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $events_colors = Event::with('hall')->where('status', 1)->get()->toArray();
        $events = Event::select('id', 'title', 'start', 'end')->where('status', 1)->get()->toArray();
        $slots = Slot::with('workshop')->get()->toArray();

        $workshop = [];
        for ($s = 0; $s < count($slots); $s++) {
            if (Config::get('app.locale') == 'ar') {
                ray($slots[$s]['workshop']['id']);
                $workshop[$s]['title'] = $slots[$s]['workshop']['title']['ar'];
            } else {
                $workshop[$s]['title'] = $slots[$s]['workshop']['title']['en'];
            }
            $workshop[$s]['description'] = $slots[$s]['name'];
            $workshop[$s]['start'] = $slots[$s]['start_date'];
            $workshop[$s]['end'] = $slots[$s]['end_date'];
            $workshop[$s]['duration'] = '02:00';
            $workshop[$s]['backgroundColor'] = '#a855f7';
        }
        // dd($workshop);
        if (count($events) > 0) {
            $e_color = [];

            foreach ($events_colors as $key => $value) {
                array_push($e_color, $events_colors[$key]['hall']['backgroundColor']);
            }

            for ($i = 0; $i < count($events); $i++) {
                $events[$i]['backgroundColor'] = $e_color[$i];
                $events[$i]['url'] = 'events/' . $events[$i]['id'] . '/edit/';
            }
            $events = array_merge($events, $workshop);

            $this->events = json_encode($events);
        } else {
            $this->events = json_encode($events);
        }
        return view('livewire.admin.event-calendar');
    }
}
