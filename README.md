Openbay
=======

After our first OpenBay release publication on GitHub, over 3700 stars were received from you, more than 1100 forks and 41 commits been created. Surprising for us, OpenBay became one of the most popular GitHub projects in December 2014. To tell the truth, we didn’t expect such results at all but this high attention to our project had only proved to us your keen interest in the project evolution. As a result, our team’s got an idea to conduct an unprecedented campaign in the torrent industry.

We’re giving $50000 for the OpenBay development - let’s build a dream torrent site together!

Anybody can participate. All details of the campaign, tasks and their rewards can be found [here](https://oldpiratebay.org/100k).  We want to stimulate you this way to input even more efforts to the project as now you can earn some money and not just work together on one huge project. 

And, of course, in order to let this idea start we completely renewed the code that will actually become that core we will develop all together.
We do realize that some of you are seriously frustrated, unsatisfied and even mad at us for our total OpenBay renewal! You probably think that we care shit about the efforts of those brave developers that found some extra time to improve an old version. However, we think different.
Each and any of you can send us an e-mail([openbay@hush.com](mailto:openbay@hush.com)) about your idea or improvement that you’ve made for the old version of OpenBay. If our team finds your suggestion interesting, we are ready to negotiate with you about  it’s implementation for OpenBay 2.0 for a reward or to place your idea as a competition task for the developers all over the world on the site:[https://oldpiratebay.org/100k/developers](https://oldpiratebay.org/100k/developers)

The main update is the migration to Yii2 which will allow us to develop modules maximum independent from each other. This will significantly facilitate the simultaneous development of different modules. Besides, architecture structure is now much better and easier. We hope that you will appreciate our efforts that will definitely make the collaborative work on OpenBay much easier in the future. 

CHANGELOG:
----------

- Full migration to Yii2
- Comment module created
- Rating module created
- Complains module created

GETTING STARTED
---------------

You can already download and install all of these using migrations:
```
yii migrate
yii migrate --migrationPath=@frontend/modules/comment/migrations
yii migrate --migrationPath=@frontend/modules/complain/migrations
yii migrate --migrationPath=@frontend/modules/rating/migrations
```
and [instruction on the Sphinx setup](https://github.com/isohuntto/openbay/wiki/sphinx)

Attention: Don’t forget to fill the config files!

Thus, we’re refusing to support an old version. However, those wishing to develop an old version of OpenBay by themselves can still access it in the [master-1.0 branch](https://github.com/isohuntto/openbay/tree/master-1.0).

P.S. Also, all our team wants to bring our sincere apologies to all those who had been waiting so long for our update and to thank all those who was so patient to wait till it was finally released! 
