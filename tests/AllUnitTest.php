<?php

//Тесты гетеров всех классов

namespace Game\App\Tests;

use Game\App\Classes\CalendarTournaments;
use Game\App\Classes\ListPlayers;
use Game\App\Classes\Players;
use Game\App\Classes\Teams;
use PHPUnit\Framework\TestCase;

class AllUnitTest extends TestCase {

  
    public function testCalendarTournamentsGetters()
    {
        
        $id = 1;
        $event_name = 'event_name';
        $start_date = '2024-05-01';
        $end_date = '2024-05-03';
        $event_city = 'New York';
        $event_country = 'USA';
        $description = 'description';
        $format = 'format';
        $prize_pool = 50000;
        $logo = ['name' => 'logo.png'];

        
        $cal_tour = new CalendarTournaments($event_name, $start_date, $end_date, $event_city, $event_country, $description, $format, $prize_pool, $logo, $id);

        
        $this->assertNotNull($id, $cal_tour->getId());
        $this->assertEquals($event_name, $cal_tour->getEventName());
        $this->assertEquals($start_date, $cal_tour->getStartDate());
        $this->assertEquals($end_date, $cal_tour->getEndDate());
        $this->assertEquals($event_city, $cal_tour->getEventCity());
        $this->assertEquals($event_country, $cal_tour->getEventCountry());
        $this->assertEquals($description, $cal_tour->getDescription());
        $this->assertEquals($format, $cal_tour->getFormat());
        $this->assertEquals($prize_pool, $cal_tour->getPrizePool());
        $this->assertEquals($logo['name'], $cal_tour->getLogo());
    }

    public function testListPlayersGetters()
    {
        
        $id = 1;
        $name = 'Alice';
        $role = 'Role';
        $country = 'Canada';

        
        $list = new ListPlayers($name, $role, $country, $id);

        
        $this->assertNotNull($id, $list->getId());
        $this->assertEquals($name, $list->getName());
        $this->assertEquals($role, $list->getRole());
        $this->assertEquals($country, $list->getCountry());
    }

 
    public function testPlayersGetters()
    {
        
        $id = 1;
        $image = ['name' => 'image.png'];
        $player_name = 'player_name';
        $career_description = 'Professional gamer with 10 years ';
        $game_experience = 10;
        $country_of_origin = 'USA';
        $total_earnings = 600000;

        
        $play = new Players($image, $player_name, $career_description, $game_experience, $country_of_origin, $total_earnings, $id);

        
        $this->assertNotNull($id, $play->getId());
        $this->assertEquals($image['name'], $play->getImage());
        $this->assertEquals($player_name, $play->getPlayerName());
        $this->assertEquals($career_description, $play->getCareerDescription());
        $this->assertEquals($game_experience, $play->getGameExperience());
        $this->assertEquals($country_of_origin, $play->getCountryOfOrigin());
        $this->assertEquals($total_earnings, $play->getTotalEarnings());
    }

  

    public function testTeamsGetters()
    {
    
        $id = 1;
        $name = 'Eagles';
        $logo = ['name' => 'logo.png'];
        $description = 'description';
        $coach_name = 'coach_name';
        $coach_experience = '10 years';

        
        $team = new Teams($name, $logo, $description, $coach_name, $coach_experience, $id);

        
        $this->assertNotNull($id, $team->getId());
        $this->assertEquals($name, $team->getName());
        $this->assertEquals($logo['name'], $team->getLogo());
        $this->assertEquals($description, $team->getDescription());
        $this->assertEquals($coach_name, $team->getCoachName());
        $this->assertEquals($coach_experience, $team->getCoachExperience());
    }
}







