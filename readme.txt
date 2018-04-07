=== Teams of Tennis ===
Contributors: vrriecke
Tags: tennis,btv,team,club,sport
Donate link: not available yet
Requires at least: 4.9
Tested up to: 4.9.4
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

show all games of a tennis team or club from the BTV site inside an iframe, manage game availability of players

== Description ==
* your are playing tennis inside Bavarian?
* you want to display the games and players of your team from the BTV page?
* you want to find out which games comes next for your club?
* you want to see the availability of your team members for all your games?

    Then this plugin is the right one.

1. With a simple shortcode you can display your team inside your own homepage.
2. Also with a shortcode you can find out, which games comes next for your club.
3. And organizing your team availability is also possible with simple shortcode. This feature is only available for logged in users.

For further details see installation section.

== Installation ==
1. Install and activate plugin teams-of-tennis
2. On settings page you can find 3 links to the BTV page
2.1. Team Link: link to the embedded team page: *http://btv.liga.nu...&team=*, the team number will be added by the shortcode, see below
2.2. Club Link: link to the embedded club page for searching games: *http://btv.liga.nu...&club=*, the club number will be added by the shortcode, see below
3. Go to the site, where you want to display the team, club or availability using a shortcode
3.1. Team link shortcode: [vr_tennisteam team="**#number**" width="100%" height="500"] 
3.1.1. width and height are optional (shown values are default)
3.1.2. How to get the #number? Go to the BTV page of your team 
    * via searching your club and then select your team or
    * search inside the teams page for your league and select your team
 and use the number behind *team=* and then the embedded part of this page (beginning with *Mannschaftsportrait*) will be displayed in front end
3.2. Club link shortcode: [vr_tennisclub club="**#number**" width="100%" height="500"]
3.2.1. width and height are optional (shown values are default)
3.2.2. How to get the #number? Go to the BTV page of your club via searching, select info about your club and use the number in brackets after your club name
 and then the embedded part of this page (beginning with *your club name*) will be displayed in the front end
3.3 Availability shortcode: [vr_tennisavailable team="**#number**" width="100%" height="500"]
3.3.1. width and height are optional (shown values are default)
3.3.2. How to get the #number? In the same way as team link (see 3.1.2)
3.3.3. If you logged in as a user, you can add a username to the availability list and also remove a user (no restriction on your own entry). 
    By clicking on the symbol under a game, you can switch the state from: unknown to yes to no to ifneeded and back to unknown.
    The list of games will be extracted from the Team link site by analyzing the html content and stored to the database.

== Frequently Asked Questions ==

== Screenshots ==
1. Back end settings
2. Front end game availability of players
3. Front end games of a team
4. Front end searching for club games

== Changelog ==
trunk - initial version

== Upgrade Notice ==
