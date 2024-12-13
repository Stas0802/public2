<?php 

namespace Game\App\Tests;

use Game\App\Classes\CalendarTournaments;
use Game\App\Classes\Database;
use Game\App\Classes\ListPlayers;
use Game\App\Classes\Players;
use Game\App\Classes\Teams;
use PHPUnit\Framework\TestCase;

class AllIntegrationTest extends TestCase 
{
   
    protected $db;

    protected function setUp(): void
    {
        $this->db = Database::getInstance()->getConnection();
        $this->db->query("TRUNCATE TABLE calendar");
        $this->db->query("TRUNCATE TABLE teams");
        $this->db->query("TRUNCATE TABLE player_table");
        $this->db->query("TRUNCATE TABLE players_list");
    }

   //Тесты класса CalendarTournaments
    public function testSaveDbCalendarTournaments()
    {
        $cal_tour = new CalendarTournaments( 'GO', '2024-11-11', '2024-11-12', 'Kiev', 'Ukraine', 'description', 'One', 1000000, ['name'=> 'image.png', 'logo_path' => 'logo_path']);
        $cal_tour->saveDb();

        $cal_tour = $this->db->query("SELECT * FROM calendar WHERE id = " . $cal_tour->getId())->fetch_assoc();
        $this->assertEquals(1, $cal_tour['id']);
        $this->assertEquals('GO', $cal_tour['event_name']);
        $this->assertEquals('2024-11-11', $cal_tour['start_date']);
        $this->assertEquals('2024-11-12', $cal_tour['end_date']);
        $this->assertEquals('Kiev', $cal_tour['event_city']);
        $this->assertEquals('Ukraine', $cal_tour['event_country']);
        $this->assertEquals('description', $cal_tour['description']);
        $this->assertEquals('One', $cal_tour['format']);
        $this->assertEquals(1000000, $cal_tour['prize_pool']);
        //$this->assertEquals('image.png', $cal_tour['logo_path']);
    }

    public function testUpdateDbCalendarTournaments()
    {
        $this->db->query("INSERT INTO calendar (id, event_name, start_date, end_date, event_city, event_country, description, format, prize_pool, logo_path) VALUES (1, 'initial_event', '2024-01-01', '2024-01-02', 'Kyiv', 'Ukraine', 'initial_description', 'Initial', 500000, 'updated_image.png')");

        $cal_tour = new CalendarTournaments( 'Updated Event', '2024-12-01', '2024-12-02', 'Lviv', 'Ukraine', 'Updated Description', 'Updated Format', 2000000, 1);
        $cal_tour->saveDb();

        $cal_tour = $this->db->query("SELECT * FROM calendar WHERE id = " . $cal_tour->getId())->fetch_assoc();
        //$this->assertEquals(1, $cal_tour['id']);
        $this->assertEquals('Updated Event', $cal_tour['event_name']);
        $this->assertEquals('2024-12-01', $cal_tour['start_date']);
        $this->assertEquals('2024-12-02', $cal_tour['end_date']);
        $this->assertEquals('Lviv', $cal_tour['event_city']);
        $this->assertEquals('Ukraine', $cal_tour['event_country']);
        $this->assertEquals('Updated Description', $cal_tour['description']);
        $this->assertEquals('Updated Format', $cal_tour['format']);
        $this->assertEquals(2000000, $cal_tour['prize_pool']);
        //$this->assertEquals('updated_image.png', $cal_tour['logo_path']);
    }

    public function testFetchByIdCalendarTournaments()
    {
       $this->db->query("INSERT INTO calendar (id, event_name, start_date, end_date, event_city, event_country, description, format, prize_pool, logo_path) VALUES (1, 'test_event', '2024-01-01', '2024-01-02', 'Kyiv', 'Ukraine', 'test_description', 'Test', 1000000, 'test_image.png')");

        $cal_tour = CalendarTournaments::fetchById(1);
        $this->assertEquals(1, $cal_tour['id']);
        $this->assertEquals('test_event', $cal_tour['event_name']);
        $this->assertEquals('2024-01-01', $cal_tour['start_date']);
        $this->assertEquals('2024-01-02', $cal_tour['end_date']);
        $this->assertEquals('Kyiv', $cal_tour['event_city']);
        $this->assertEquals('Ukraine', $cal_tour['event_country']);
        $this->assertEquals('test_description', $cal_tour['description']);
        $this->assertEquals('Test', $cal_tour['format']);
        $this->assertEquals(1000000, $cal_tour['prize_pool']);
        //$this->assertEquals('test_image.png', $cal_tour['logo_path']);
    }

    public function testFetchAllCalendarTournaments()
    {
        $this->db->query("INSERT INTO calendar (id, event_name, start_date, end_date, event_city, event_country, description, format, prize_pool, logo_path) VALUES (1, 'event1', '2024-01-01', '2024-01-02', 'Kyiv', 'Ukraine', 'description1', 'Format1', 1000000, 'image1.png')");
        $this->db->query("INSERT INTO calendar (id, event_name, start_date, end_date, event_city, event_country, description, format, prize_pool, logo_path) VALUES (2, 'event2', '2024-02-01', '2024-02-02', 'Lviv', 'Ukraine', 'description2', 'Format2', 2000000, 'image2.png')");

        $calendar = CalendarTournaments::fetchAll();
        $this->assertCount(2, $calendar);
    }

    public function testDeleteByIdCalendarTournaments()
    {
        $this->db->query("INSERT INTO calendar (id, event_name, start_date, end_date, event_city, event_country, description, format, prize_pool, logo_path) VALUES (1, 'event_name', '2024-01-01', '2024-01-02', 'Kyiv', 'Ukraine', 'description', 'Format', 1000000, 'image.png')");

        CalendarTournaments::deleteById(1);
        
        $cal_tour = CalendarTournaments::fetchById(1);
        $this->assertNull($cal_tour, 'Запись должна была быть удалена, но она все еще существует');
    }


//Тесты класса Teams
    public function testSaveDbTeams()
    {
        $team = new Teams('Team A',  ['name'=> 'image.png', 'logo_path' => 'logo_path'], 'Description of Team A', 'Coach A', 5);
        $team->saveDb();

        $team = $this->db->query("SELECT * FROM teams WHERE id = " . $team->getId())->fetch_assoc();
        $this->assertEquals(1, $team['id']);
        $this->assertEquals('Team A', $team['name']);
        //$this->assertEquals('image.png', $team['logo_path']);
        $this->assertEquals('Description of Team A', $team['description']);
        $this->assertEquals('Coach A', $team['coach_name']);
        $this->assertEquals(5, $team['coach_experience']);
    }

    public function testUpdateDbTeams()
    {
        $this->db->query("INSERT INTO teams (id, name, logo_path, description, coach_name, coach_experience) VALUES (1, 'Team B', 'initial_logo.png', 'Initial description', 'Coach B', 3)");

        $team = new Teams('Team B Updated', 'updated_logo.png', 'Updated description', 'Coach B Updated', 6, 1);
        $team->saveDb();

        $team = $this->db->query("SELECT * FROM teams WHERE id = " . $team->getId())->fetch_assoc();
        $this->assertEquals(1, $team['id']);
        $this->assertEquals('Team B Updated', $team['name']);
        //$this->assertEquals('updated_logo.png', $teamFromDb['logo_path']);
        $this->assertEquals('Updated description', $team['description']);
        $this->assertEquals('Coach B Updated', $team['coach_name']);
        $this->assertEquals(6, $team['coach_experience']);
    }

    public function testFetchByIdTeams()
    {
        $this->db->query("INSERT INTO teams (id, name, logo_path, description, coach_name, coach_experience) VALUES (1, 'Team C', 'logo_c.png', 'Description C', 'Coach C', 4)");

        $team = Teams::fetchById(1);
        $this->assertEquals(1, $team['id']);
        $this->assertEquals('Team C', $team['name']);
        //$this->assertEquals('logo_c.png', $team['logo_path']);
        $this->assertEquals('Description C', $team['description']);
        $this->assertEquals('Coach C', $team['coach_name']);
        $this->assertEquals(4, $team['coach_experience']);
    }

    public function testFetchAllTeams()
    {
        $this->db->query("INSERT INTO teams (id, name, logo_path, description, coach_name, coach_experience) VALUES (1, 'Team D', 'logo_d.png', 'Description D', 'Coach D', 7)");
        $this->db->query("INSERT INTO teams (id, name, logo_path, description, coach_name, coach_experience) VALUES (2, 'Team E', 'logo_e.png', 'Description E', 'Coach E', 8)");

        $teams = Teams::fetchAll();
        $this->assertCount(2, $teams);
    }

    public function testDeleteByIdTeams()
    {
        $this->db->query("INSERT INTO teams (id, name, logo_path, description, coach_name, coach_experience) VALUES (1, 'Team F', 'logo_f.png', 'Description F', 'Coach F', 9)");

        Teams::deleteById(1);

        $team = Teams::fetchById(1);
        $this->assertNull($team, 'Запись с ID 1 должна была быть удалена, но она все еще существует');
    }

   

   //тесты класса  players

    public function testSaveDbPlayers()
    {
        $play = new Players(['name'=> 'image.png', 'image_path' => 'image_path'], 'Player A', 'Career description A', 5, 'Country A', 10000);
        $play->saveDb();

        $play = $this->db->query("SELECT * FROM player_table WHERE id = " . $play->getId())->fetch_assoc();
        $this->assertEquals(1, $play['id']);
        //$this->assertEquals('image.png', $play['image_path']);
        $this->assertEquals('Player A', $play['player_name']);
        $this->assertEquals('Career description A', $play['career_description']);
        $this->assertEquals(5, $play['game_experience']);
        $this->assertEquals('Country A', $play['country_of_origin']);
        $this->assertEquals(10000, $play['total_earnings']);
    }

    public function testUpdateDbPlayers()
    {
        $this->db->query("INSERT INTO player_table (id, image_path, player_name, career_description, game_experience, country_of_origin, total_earnings) VALUES (1, 'initial_image.png', 'Player B', 'Initial career description', 3, 'Country B', 20000)");

        $play = new Players('updated_image.png', 'Player B Updated', 'Updated career description', 6, 'Country B Updated', 30000, 1);
        $play->saveDb();

        $play = $this->db->query("SELECT * FROM player_table WHERE id = " . $play->getId())->fetch_assoc();
        $this->assertEquals(1, $play['id']);
        //$this->assertEquals('updated_image.png', $play['image_path']);
        $this->assertEquals('Player B Updated', $play['player_name']);
        $this->assertEquals('Updated career description', $play['career_description']);
        $this->assertEquals(6, $play['game_experience']);
        $this->assertEquals('Country B Updated', $play['country_of_origin']);
        $this->assertEquals(30000, $play['total_earnings']);
    }

    public function testFetchByIdPlayers()
    {
        $this->db->query("INSERT INTO player_table (id, image_path, player_name, career_description, game_experience, country_of_origin, total_earnings) VALUES (1, 'test_image.png', 'Player C', 'Test career description', 4, 'Country C', 40000)");

        $play = Players::fetchById(1);
        $this->assertEquals(1, $play['id']);
        //$this->assertEquals('test_image.png', $player['image_path']);
        $this->assertEquals('Player C', $play['player_name']);
        $this->assertEquals('Test career description', $play['career_description']);
        $this->assertEquals(4, $play['game_experience']);
        $this->assertEquals('Country C', $play['country_of_origin']);
        $this->assertEquals(40000, $play['total_earnings']);
    }

    public function testFetchAllPlayers()
    {
        $this->db->query("INSERT INTO player_table (id, image_path, player_name, career_description, game_experience, country_of_origin, total_earnings) VALUES (1, 'image1.png', 'Player D', 'Career description D', 7, 'Country D', 50000)");
        $this->db->query("INSERT INTO player_table (id, image_path, player_name, career_description, game_experience, country_of_origin, total_earnings) VALUES (2, 'image2.png', 'Player E', 'Career description E', 8, 'Country E', 60000)");

        $player_table = Players::fetchAll();
        $this->assertCount(2, $player_table);
    }

    public function testDeleteByIdPlayers()
    {
        $this->db->query("INSERT INTO player_table (id, image_path, player_name, career_description, game_experience, country_of_origin, total_earnings) VALUES (1, 'image.png', 'Player F', 'Career description F', 9, 'Country F', 70000)");

        Players::deleteById(1);

        try {
            $play = Players::fetchById(1);
            $this->assertNull($play, 'Запись с ID 1 должна была быть удалена, но она все еще существует');
        } catch (\Exception $e) {
            $this->assertEquals("Запісь по id = (1) не знайдено", $e->getMessage());
        }
    }

//Тесты класса ListPlayers

    public function testSaveDbListPlayers()
    {
        $list = new ListPlayers('John Doe', 'Attacker', 'USA');
        $list->saveDb();

        $list = $this->db->query("SELECT * FROM players_list WHERE id = " . $list->getId())->fetch_assoc();
        $this->assertEquals(1, $list['id']);
        $this->assertEquals('John Doe', $list['name']);
        $this->assertEquals('Attacker', $list['role']);
        $this->assertEquals('USA', $list['country']);
    }

    public function testUpdateDbListPlayers()
    {
        $this->db->query("INSERT INTO players_list (id, name, role, country) VALUES (1, 'Jane Doe', 'Defender', 'Canada')");

        $list = new ListPlayers('Jane Doe Updated', 'Midfielder', 'Canada', 1);
        $list->saveDb();

        $list = $this->db->query("SELECT * FROM players_list WHERE id = " . $list->getId())->fetch_assoc();
        $this->assertEquals(1, $list['id']);
        $this->assertEquals('Jane Doe Updated', $list['name']);
        $this->assertEquals('Midfielder', $list['role']);
        $this->assertEquals('Canada', $list['country']);
    }

    public function testFetchByIdListPlayers()
    {
        $this->db->query("INSERT INTO players_list (id, name, role, country) VALUES (1, 'Sam Smith', 'Goalkeeper', 'UK')");

        $list = ListPlayers::fetchById(1);
        $this->assertEquals(1, $list['id']);
        $this->assertEquals('Sam Smith', $list['name']);
        $this->assertEquals('Goalkeeper', $list['role']);
        $this->assertEquals('UK', $list['country']);
    }

    public function testFetchAllListPlayers()
    {
        $this->db->query("INSERT INTO players_list (id, name, role, country) VALUES (1, 'Player A', 'Role A', 'Country A')");
        $this->db->query("INSERT INTO players_list (id, name, role, country) VALUES (2, 'Player B', 'Role B', 'Country B')");

        $players_list = ListPlayers::fetchAll();
        $this->assertCount(2, $players_list);
    }

    public function testDeleteByIdListPlayers()
    {
        $this->db->query("INSERT INTO players_list (id, name, role, country) VALUES (1, 'Player C', 'Role C', 'Country C')");

        ListPlayers::deleteById(1);

        try {
            $list = ListPlayers::fetchById(1);
            $this->assertNull($list, 'Запись с ID 1 должна была быть удалена, но она все еще существует');
        } catch (\Exception $e) {
            $this->assertEquals("Запісь по id = (1) не знайдено", $e->getMessage());
        }
    }
}



   
