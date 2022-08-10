###[DEF]###
[name = Xiaomi Roborock Reinigungskarte]

[folderid = 170]
[xsize = 100]
[ysize = 50]

[var1 = robot1]
[var2 = wild]
[var3 = 2000]
[var4 = 10000]
    
[flagText = 0]
[flagKo1 = 1]
[flagKo2 = 1]
[flagKo3 = 0]
[flagPage = 0]
[flagCmd = 1]
[flagDesign = 0]
[flagDynDesign = 0]

###[/DEF]###

###[PROPERTIES]###
[columns=25,25,25,25]

[row = Einstellungen]
    [var1 = select,1,'Roboter-Icon','robot#Roboter|robot1#Roboter-1|spaceship#Raumschiff|tank#Panzer']
    [var2 = select,1,'Kartenfarben','wild#Durcheinander|blau#Blau-Töne|pastell#Pastell-Töne|x1#X1']
[row = Klick-Zeit]
    [var3 = select,2,'Verzögerung','1000#1 Sekunde|2000#2 Sekunden|3000#3 Sekunden|4000#4 Sekunden|5000#5 Sekunden']
[row = Kartenaktualisierung]
    [var4 = select,2,'Intervall','0#Deaktiviert|5000#5 Sekunden|10000#10 Sekunden|20000#20 Sekunden|30000#30 Sekunden|40000#40 Sekunden|50000#50 Sekunden']

###[/PROPERTIES]###

###[EDITOR.JS]###
VSE_VSEID=function(elementId,obj,meta,property,isPreview,koValue) {
    VSE_VSEID_CreateElement(elementId,obj);

    return true;
}
###[/EDITOR.JS]###

###[VISU.PHP]###
<?
function PHP_VSE_VSEID($cmd,$json1,$json2) {
    if ($cmd == "loadImg") {
        if (isset ($json1['url'])) {
            $string = file_get_contents($json1['url']);
            if ($string) {
?>
                const elementId = <?echo $json1['elementId'];?>;
                var veVar=visuElement_getGlobal(elementId);
                
                veVar.XiaomiView.loadBufferFromBase64 ('<?echo base64_encode($string);?>');
                VSE_VSEID_CanvasMap (elementId);
<?
            }
        }
    }
}
?>
###[/VISU.PHP]###
    
###[VISU.JS]###
VSE_VSEID_CONSTRUCT=function(elementId,obj) {
    const obstacle = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAAtFBMVEV6ADo/n/7////6/P5Dof5Fov9Lpf/x9/9rtf/0+v/2+/xRqP9ZrP/o9/rr9f+Dwf7H5P9hsP6Nxv/v+fvP5//l8v5zuf+a2+iU2OZmsv7Y8feq4OzG6/Lb7f+ezv6L1eTA4P+y4u7N7fSo0//i9fi12f+65e/f7//U6f+Vyf+P1uWazP+73f7v9v94u//e8/jY6/+t1f99vv+42/7i8P++5/Cl0f6f3OnS7/Wj3eqx1/+i0P4ph2dZAAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAKnSURBVEjHjVZrr6owEJRtAas8hOpJJNcTohgliigaY/T//6+7BVT6UM58IpShs7OPdjAwIcl4WfKsHPwNCSfwAuG9tMSvvyfMDQKXNc9+8oXwzxefzNLfynNs2/EOu3QmaHz5iZHhMksrx+rAOaQukjIzgyNhP7c0RGuGKyYGbrH4sYwYHlGvJm5JgKwd6wOcEy4n2h5sR62PoDlTOcjIra+IXSBy5GRn9SAnwDvuAtxpH8XCePxO6Ect8rGn/sTeAtxespjm7qNwz7bqtfuUlgCctfRh9kiovr0DNFXqg6vl/CQKcqL9qGi3IZBqqbsIihup78+N0SWQg7pUNS1zVd//kFoZh5lm175psKNqAN3Uygy6xkHdW9OYmpUBaKWS4/fBekgtWysbgDoULSlbts1R7Hw1VSXPCSRoMfNUXSexQTjF3MTqkrCZQWFok+i6qU2bqkUzgxEKC1TFdjVh7UzaKr+jFxwDOmW4aAdZsK8MLmcGYWn9PTvuxqg9pKowLipMDt8rxCy7CwcO50CpjDr8TDU5B3cS4sZe48BZNbnUU3l9YDWO44nbBCRXUyhSiQWjdgsd3oP3IJdSs64LhsNF8sXbbRl00E0NXdRlmUjBOPsCZLBO1wxZM507ypwoJqBi5dlvXdBOi6L9kbdhOgMPm2cNeEE7zsUUezWdEc/MXZ/jArdp5wV9pEbkyrTA0Ye22L3D0qITgNck94Fc+ym/0lAeAYv7GCHDVpEOC7f6zjgUQG7S4Y2cr/uExcutJ0o8lB4fPaA7rCFfuyTgaTidmxnRBBcN14zlCKBYeTph/EBRo+TTwQ+BaEepqU4zMIh633hE5S7uYeTYlOKNJLwfRSN8vfvceFOJwWWxuARN37Ck77KUyZer7G9XsmXGMwTPbqbV/xhsNQhYXE5WAAAAAElFTkSuQmCC";
  
    const robot = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAE7AAABOwBim79cgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAfrSURBVFiFpVdraFTbFf7WmSRmYjTRThInEY3WJEZjMErFBFHESKEWWxQ0BhSVC3rl/ihWLFQjRrFKKxIkPkBaKgoiKGh8gBgU0yAWMZTaWAxJMNHM40xmMo/M65yz1+6P2eMdc6OmuGEzZ87Ze69vrW899iJMfZD6dQBYDmARgEL1PgzgHYB/A3iv1sn/4+yvCv4ZgN8B+CcAEwCrKdTM/P8fAMcBzM0A/cXDvzTyABwCcBDATCICALO0tHS8qqpKFBUVMTNzJBLJ7uvr04aGhuzMbJdSSgAGgCsAWgGMArApgFPWug7AfwEwEXFVVVXg/Pnz+tDQUFAIwcwshRBSCCFZDV3Xw1evXvWuWrVqlIgsZRU3gF9OxRqZwn8DIAKAHQ5H8MaNG7ppmpYSJj58+BB5+PChfvnyZdeFCxfcd+7c8fX19YWEQiaE4MePH/sqKir8CoSJFIVTArEZQAKAbGxs9Pj9/qgyc7ytrc1XWVnp0zTNACCJiImI1bNZVlbmb2lp8em6Ps7MMhqNJvfs2eMmorSfHPwaiDoAESKSTU1NI4lEwmBmeffuXV9xcfEYEUkikpqmGSUlJYG6ujrvypUr9dLSUp/NZosrMJyfnx+5dOmSh5kFM4ujR4++V5RYAH79OeF2AL0AeP369R4lnFtaWtxEZBKRdDgcwVOnTnnevXsXTFn6Rx/wer2RS5cueebPn+9XQMWOHTvcyWTSYmaxb98+FxFJAD4Acybj/Y+K85Df7x9nZqmECyISu3btcgeDwRgzSymlZGbu7Ox0P3r0yBWLxQz1TsbjcePIkSNuTdMMIpLbt293W5Yl4vG4sXTpUh9S+eHvE6koBOAnIr5+/bqHmeWDBw98RGQQkdXa2urmtGQ1TNM0c3JyYkQk+vv7Y5nfmFleu3bNa7PZDCIS586d8zCzfPHihY+IDKSccnGm9j8A4AULFowahmHFYrGk0+kMAJA7d+70CCE+EZ4BID4ZgDSIkydPuomIc3Nzx10uV4SZeePGjV7lkOfTViAA/yAiPnv2rEcIIdvb2z2K81AwGPzJ4VMBIKWUhmGYNTU1o0QkDxw44GZmee/ePa/yBReALACYBcAgImNwcHCMmXnZsmV+AKxMP9nZ0jRN0263j2qaFhocHByfbA0zy5s3b3qISBYWFoYTiYQRi8XieXl5IWWFOgBYC4BLSkr8zGyNjIyEiChORMmBgQH/pNLViEajsVgsFp2Mosw1drs9SETc3d3tE0LI+vr6NA3faQB+DgDl5eWmlNLW19eXBJA7a9as8fLy8plfShp5eXl2u92ep2naZ5OL3W7Pra6uTgJAT0+PBIAlS5aQomGBpijA3Llzs4kIXq83V0opnU4npzn6xkGLFi0iIqJAIGAHIOfMmZODlO8VpgVIVenAzBoAZGdnf1YrKT+W+vRDyptp8i1ZWVma2qdNWEcaUpcJcrvdJgDpcDjiREQjIyMSk5RPKSW6uroCmzdvDjqdzlhRUVF0w4YNoVu3bvmllDwZ3oGBAUtKKQsKCqIASNd1Q4EPAsAGAFxWVuZnZjE4OBggoiQRJYaHh4MTvfrYsWOedGqeMEVzc7PHNE0rc08ikUjm5+ePERE/efLEI4SQa9eu1ZFywu8BoASApWlawuVyBYUQYuHChWNEJNva2vTMMLx9+7aXiCwi4i1btox2dnb6u7u7A/v379c1TTOJiE+fPu3J3PPw4UOdiDgvLy8SiUTihmEkZ86cGVQA6tP8vSIivnz5slcIIU+cOOEmIul0Ov3RaDShio6orq7WAci9e/fqmalZCCHPnDmjA5AFBQVj0Wg0LoSQlmVZq1ev9hIRNzc3e5hZPn36VFdVcxTAtDSAPwDg2tpanZlFIBCIzZgxIwRAzp8/P1RTUxOprq4OK9Mb/f39gUniPT5t2rQQAK6oqAjV1NREKisrwwBEVlZW/O3bt2NCCLl161a30v6vyChIcwCME5F1//59DzPLK1eueJS5P/KMVLTEAoHATzIfM4vi4uKgWvPJPHz4sIuZ5Zs3b/w2my2unPsXyEBAAP4C4OC8efPGent7p0+fPj3n8ePHEdM0swBACCGampqQSCTyOzo6/Js2bXJkht2bN2+CNTU10wHIq1evhmfPnp2nPnFjY2OOzWazrVu3zv/8+fMiAPcA/BYTru6FAIYByKamJjczi4kRsHv3bg8RsdPpDL9+/TqQvoy4XK7w8uXLx4hINjQ06BNLtxBCtra2uhT3EaR6iknHegBJIhKHDh16PxGEz+eLlpWVhYlI2my2+IoVK/SGhgY9JydnHIDMz8+P9vb2hiYKb29v/0BE6X7iu88JT1PxPVJXcbFnzx53LBYzMhUaHh6O1NfXj6bDMT2rqqoCPT09n+QNy7Ks48ePuzOE/xlTbFZ+QOrWIhcvXjza3d09qsyd1opfvXrlu3jx4lh7e3v42bNnumEYHxOQcrixNWvWeJXZhRKufU14JohfAfAAYE3TzMbGRl9HR8doPB5PpMFYliUty5LMLJlZGoZhdHV1BbZt26ZnZ2cnlNYRZfZJNf+aOUoA/AnATgBZRITc3NxoXV1dsra2VnM4HFkAZDgc5t7eXn758mVWJBKZIVPFSgJ4AOD3APrxDc0qAagE0AZgRGnF6rb80QfwY4PqB/A3pOL8m5vTiWttAJYBWAlgAVJ3CQIQQiqE/wXgFVKN6ZQ0/h8isDW9jjqpOwAAAABJRU5ErkJggg==";
    const robot1 = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAfCAMAAAHGjw8oAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAADbUExURQAAAICAgICAgICAgICAgICAgHx8fH19fX19fYCAgIGBgX5+foCAgH5+foCAgH9/f39/f35+foCAgH9/f39/f4CAgH5+foGBgYCAgICAgIGBgX9/f39/f35+foCAgH9/f39/f4CAgIODg4eHh4mJiZCQkJycnJ2dnZ6enqCgoKSkpKenp62trbGxsbKysry8vL29vcLCwsXFxcbGxsvLy87OztPT09XV1d/f3+Tk5Ojo6Ozs7O3t7e7u7vHx8fLy8vPz8/X19fb29vf39/j4+Pn5+f39/f7+/v///9yECocAAAAgdFJOUwAGChgcKCkzOT5PVWZnlJmfsLq7wcrS1Nre4OXz+vr7ZhJmqwAAAAlwSFlzAAAXEQAAFxEByibzPwAAAcpJREFUKFNlkolaWkEMhYPggliBFiwWhGOx3AqCsggI4lZt8/5P5ElmuEX5P5hMMjeZJBMRafCvUKnbIqpcioci96owTQWqP0QKC54nImUAyr9k7VD1me4YvibHlJKpVUzQhR+dmdTRSDUvdHh8NK8nhqUVch7cITmXA3rtYDmH+3OL4XI1T+BhJUcXczQxOBXJuve0/daeUr5A6g9muJzo5NI2kPKtyRSGBStKQZ5RC1hENWn6NSRTrDUqLD/lsNKoFTNRETlGMn9dDoGdoDcT1fHPi7EuUDD9dMBw4+6vMQVyInnPXDsdW+8tjWfbYTbzg/OstcagzSlb0+wL/6k+1KPhCrj6YFhzS5eXuHcYNF4bsGtDYhFLTOSMqTsx9e3iyKfynb1SK+RqtEq70RzZPwEGKwv7G0OK1QA42Y+HIgct9P3WWG9ItI/mQTgvoeuWAMdlTRclO/+Km2jwlhDvinGNbyJH6EWV84AJ1wl8JowejqTqTmv+0GqDmVLlg/wLX5Mp2rO3WRs2Zs5fznAVd1EzRh10OONr7hhhM4ctevhiVVxHdYsbq+JzHzaIfdjs5CZ9tGInSfoWEXuL7//fwtn9+Jp7wSryDjBFqnOGeuUxAAAAAElFTkSuQmCC";
    const charger = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAdVBMVEUAAAA44Yo44Yo44Yo44Yo44Yo44Yo44Yo44Yp26q844Yr///9767Kv89DG9t2g8Md26q5C44/5/vvz/fjY+ei19NNV5ZtJ45T2/fmY78KP7r1v6atq6Kjs/PPi+u7e+uvM9+Gb8MSS7r+H7bhm6KVh56JZ5p3ZkKITAAAACnRSTlMABTr188xpJ4aepd0A4wAAANZJREFUKM9VklmCgzAMQwkQYCSmLKWl2+zL/Y9YcIUL7wvkJHIUJyKkVcyy+JIGCZILGF//QLEqlTmMdsBEXi56igfH/QVGqvXSu49+1KftCbn+dtxB5LOPfNGQNRaKaQNkTJ46OMGczZg8wJB/9TB+J3nFkyqJMp44vBrnWYhJJmOn/5uVzAotV/zACnbUtTbOpHcQzVx8kxw6mavdpYP90dsNcE5k6xd8RoIb2Xgk6xAbfm5C9NiHtxGiXD/U2P96UJunrS/LOeV2GG4wfBi241P5+NwBnAEUFx9FUdUAAAAASUVORK5CYII=";
    const tank = "data:image/png;base64,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"
    const spaceship = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAFMklEQVRYR+2YfUxVZRjAf+cAfiAOHZaIFxXD0g2V3LVipZFuOrRcm6KBHw0b/GHERpFGfoQokcV0M6x5mbiKyFK31NRls666RmUrP0gtUVQU8IP8AEGBe297zznXe+71fsBB+4v3D8Z97/M85/c+X+9zj8SDW7eBUJ25XsDdrpqXumpAp29jSoZMTDxsXCS2+wJNXbX/YAFTVsqMeg5WTO4GNBIZG90eNOI3l063B434zwK8oCnGkrISXRWfARzAT0CGEeNCp6ttppHIYWFExYIkQc4mCOsHeclw6wY01MC/taIXip5oaHUdMPmtMBa85/7w+jq4egX2bQRrWTegv9A00u1BQ6l7T6nbgx2tYiGXCsia7yqAKqAzHowFEjR9O1Cu9Um/Mewo4ETgQJAsYXc4cDi4CER3ErBGkjDJkoTNLvo3zwMHA2VYRwGFMaujLonk9D/Z9l29IcBZL0aatpY8iTRor+BKFId+oIDj48Opqm7m+s02Q4D9w0NMsTGhHD5y8+EAYhoJDZegpdEQIL37mogYDBdPPSTA9w9B+XKotBoDjEs0kboK3p3QacBSYIEuHyZ5JLCSg/gDnPkotLeqJuRgyN/veRfX4B9QFOKPOobPgYXOIjk8tFc/85LoZ8ms2iMqdSGwWSfsH3D+CpgRzkcrRioqb+efgoKD8INFPywEAkyTJam0OHYaa2p+5vydG78D4+8BxodFmnePnsuQX9Zhc9gDAV4CHgOuKXexBlhVIc4BsQkHPAEHAGeISxzsJ8RpQZJceuGZbKYf/5IjTfXugIBZ5zHvgJZTsHkJVOxwic5dCnMWKx50A7SchN2fwo71Ltn4qTB7ma8cTANEqjmXB2DUE2bS18OqaWC3eQfcdUtVbm50mQnti+jc9wHuvKkOsXrZM2dVPe9FkoYcVMryPVCSBbV/ewCaRppZVALLEvWAInHF64zRwIc4AZ14l8/DpdMqYN5MNq0TYvBa9nHI264CDh4BA4eqGseP6gEXix1xXK0gVcDVVvgkXbSigIBlQKvyELFCesL2K7oIALOjoKVJERGM92QdDtde7zD4plbVa9Ve1aREu/5XfrbQA5hnDHBLDfQJdwdzfkoeRG56JAW5jyNH7QWL5qGMsdhrk1ha+A+FJfWwtc5d32aDE5VwpwnykwwBVgLi2FMIADh8oIMRMaF8b73mBjg1cQCnq5s5e1nqCOA+IAo5KM53iEeMM7PWCgWpcP6EeuLgECj+FWTnlOXhyOIsOKYNJELmYzGFAW8kgF1MVMCYiZCpq2S9CSGT+TS0t6m7EdGQutpHDjoBvQfz/9mtOg0tzT4AJcmseEy/JBm+vgjBIoe9rJxJcPaY9oUEX4gZFpgvZlMl+WH4GCjS32CauMhD4bnUIeDQvK1UGtDeLvTdqljcCi97IAQBawLl4ISeA5jcP4a8c1a3HMwblsj+69UcunutIzm4BLB5PP9bcfv4G1iFO1spP+e7iueYyIqII3fIBAZVFLkB1iXkUHjhEOsbKtUo6JdSxX+pVbx6uvhGhEhLRI8g+kmuYF9KPnWKtILJEf29U0s4Q8T1vhVo5I8QLdpDyxLZI+yl/WNf5ak/LNy2tYkS/UBpSzlbVNGiV8TfKOCdPkEhWb+Ny2Dy0c+ob23a5eVFkvBcg6/jBAL0prf1kZA+s8pHzWRG5Ve02NsKgaWAnXkFqnyZ+Kj8AizoLYfk7oxLIfXkdq623d4GJHfGt0YA1wLZuodkAhsUQNfbMlGOAvB1oFgnuw54szOA/wGAoJRHR2vq3wAAAABJRU5ErkJggg==";

    const myMapColors = {
        "wild" : [
            /*
              https://www.colorcombos.com/combomaker.html?design=pencils&output_width=75&size_option=element&colors=615AB6,FDD352,71CBDD,F58E6E,C9B2AA,A788E0,91C8FE,B6845A,5AB676,B6B35A,B6925A,86942A,507642,CCCFBC,AA0078,D1CAB0,A16B23,&background_color=FFFFFF&show_hex_flag=Y
            */
            '#615ab6','#fdd352','#71cbdd','#f58e6e','#c9b2aa','#a788e0','#91c8fe','#b6845a','#5ab676','#b6b35a','#b6925a','#86942A','#507642','#CCCFBC','#AA0078','#D1CAB0','#A16B23'
        ],
        "blau" : [
            /*
              https://www.colorcombos.com/combomaker.html?design=pencils&output_width=75&size_option=element&colors=2e44c5,2e53c5,2e65c5,2e74c5,3d3d3d,c9b2aa,2e8bc5,2e95c5,2ea2c5,2eb2c6,2ebec6,2ecac6,2ED6C6,2EE2C6,2EEEC6,2EFAC6,2F06C6,&background_color=FFFFFF&show_hex_flag=Y
            */
            '#2e44c5','#2e53c5','#2e65c5','#2e74c5','#3d3d3d','#c9b2aa','#2e8bc5','#2e95c5','#2ea2c5','#2eb2c6','#2ebec6','#2ecac6','#2ED6C6','#2EE2C6','#2EEEC6','#2EFAC6','#2F06C6'
        ],
        "pastell" : [
            /*
              https://www.colorcombos.com/combomaker.html?design=pencils&output_width=75&size_option=element&colors=8DA7BE,CDE6F5,AABCCA,87919E,7C818B,707078,A6919A,DBB1BC,D3C4E3,B1ADDB,8F95D3,8DB596,BEDBBB,D6B0B1,8B5E83,BEE5D3,f2dcbb,&background_color=FFFFFF&show_hex_flag=Y
            */
            '#8da7be','#cde6f5','#aabcca','#87919e','#7c818b','#707078','#a6919a','#dbb1bc','#d3c4e3','#b1addb','#8f95d3','#8DB596','#BEDBBB','#D6B0B1','#8B5E83','#BEE5D3','#f2dcbb'
        ],
        "x1" : [
            /*
              https://www.colorcombos.com/combomaker.html?design=pencils&output_width=71&size_option=element&colors=#F39001,#BCDF32,#EAEA00,2576C8,2C2C2C,BA863B,CA9ABD,9ACA9A,A2718F,7B98C2,#BC7A7D,DADA00,D37001,9CBF12,0556A8,9C5A5D,5B78A2&background_color=FFFFFF&show_hex_flag=Y
             */
            '#f39001','#bcdf32','#eaea00','#2576c8','#2c2c2c','#ba863b','#ca9abd','#9aca9a','#a2718f','#7b98c2','#bc7a7d','#DADA00','#D37001','#9CBF12','#0556A8','#9C5A5D','#5B78A2'
        ]
    };

    let imgRobot = new Image();
    let imgCharger = new Image();
    imgCharger.src = charger;
    let imgObstacle = new Image();
    imgObstacle.src = obstacle;

    imgCharger.onload = function () {};
    imgRobot.onload = function () {};
    imgObstacle.onload = function () {};

    if (obj.dataset.var1 === 'robot') {
        imgRobot.src = robot;
    } else if (obj.dataset.var1 === 'robot1') {
        imgRobot.src = robot1;
    } else if (obj.dataset.var1 === 'tank') {
        imgRobot.src = tank;
    } else if (obj.dataset.var1 === 'spaceship') {
        imgRobot.src = spaceship;
    }
    
    VSE_VSEID_CreateElement(elementId,obj,myMapColors[obj.dataset.var2][0]);
    
    function class_XiaomiView() {
        class XiaomiVSEBuffer extends Uint8Array{readUInt8(a){return this[a]}readUInt16LE(a){return(this[a+1]<<8)+this[a]}readInt16LE(a){var e=(this[a+1]<<8)+this[a];return e>=Math.pow(2,15)&&(e-=Math.pow(2,16)),e}readUInt32LE(a){return(this[a+3]<<24)+(this[a+2]<<16)+(this[a+1]<<8)+this[a+0]}readInt32LE(a){var e=(this[a+3]<<24)+(this[a+2]<<16)+(this[a+1]<<8)+this[a+0];return e>=Math.pow(2,31)&&(e-=Math.pow(2,32)),e}readNbytes(a,e){for(var r=[],t=0;t<e;t++)r.push(this[a+t]);return String.fromCharCode.apply(null,r)}}const XiaomiRRTools={DIMENSION_PIXELS:1024,DIMENSION_MM:51200},RRMapParser=function(){};RRMapParser.TYPES={CHARGER_LOCATION:1,IMAGE:2,PATH:3,GOTO_PATH:4,GOTO_PREDICTED_PATH:5,CURRENTLY_CLEANED_ZONES:6,GOTO_TARGET:7,ROBOT_POSITION:8,FORBIDDEN_ZONES:9,VIRTUAL_WALLS:10,CURRENTLY_CLEANED_BLOCKS:11,MFBZS_AREA:12,OBSTACLES:13,IGNORED_OBSTACLES:14,OBSTACLES_2:15,IGNORED_OBSTACLES_2:16,CARPET_MAP:17,DIGEST:1024},RRMapParser.PARSEBLOCK=function a(e,r,t){if(t=t||{},e.length<=r)return t;let E=0;const s=e.readUInt16LE(0+r),n=e.readUInt16LE(2+r),R=e.readUInt32LE(4+r);switch(s){case RRMapParser.TYPES.ROBOT_POSITION:case RRMapParser.TYPES.CHARGER_LOCATION:t[s]={position:[e.readUInt16LE(8+r),e.readUInt16LE(12+r)],angle:R>=12?e.readInt32LE(16+r):0};break;case RRMapParser.TYPES.IMAGE:n>24&&(E=4);const a={segments:{count:E?e.readInt32LE(8+r):0,id:[]},position:{top:e.readInt32LE(8+E+r),left:e.readInt32LE(12+E+r)},dimensions:{height:e.readInt32LE(16+E+r),width:e.readInt32LE(20+E+r)},pixels:[]};if(a.position.top=XiaomiRRTools.DIMENSION_PIXELS-a.position.top-a.dimensions.height,a.dimensions.height>0&&a.dimensions.width>0){a.pixels={floor:[],obstacle:[],segments:[]};for(let t,s=0;s<R;s++)switch(7&e.readUInt8(24+E+r+s)){case 0:break;case 1:a.pixels.obstacle.push(s);break;default:a.pixels.floor.push(s),0!==(t=(248&e.readUInt8(24+E+r+s))>>3)&&(a.segments.id.includes(t)||a.segments.id.push(t),a.pixels.segments.push(s|t<<21))}}t[s]=a;break;case RRMapParser.TYPES.PATH:case RRMapParser.TYPES.GOTO_PATH:case RRMapParser.TYPES.GOTO_PREDICTED_PATH:const o=[];for(let a=0;a<R;a+=4)o.push([e.readUInt16LE(20+r+a),e.readUInt16LE(20+r+a+2)]);t[s]={current_angle:e.readUInt32LE(16+r),points:o};break;case RRMapParser.TYPES.GOTO_TARGET:t[s]={position:[e.readUInt16LE(8+r),e.readUInt16LE(10+r)]};break;case RRMapParser.TYPES.CURRENTLY_CLEANED_ZONES:const i=[];if(e.readUInt32LE(8+r)>0){for(let a=0;a<R;a+=8)i.push([e.readUInt16LE(12+r+a),e.readUInt16LE(12+r+a+2),e.readUInt16LE(12+r+a+4),e.readUInt16LE(12+r+a+6)]);t[s]=i}break;case RRMapParser.TYPES.FORBIDDEN_ZONES:const I=[];if(e.readUInt32LE(8+r)>0){for(let a=0;a<R;a+=16)I.push([e.readUInt16LE(12+r+a),e.readUInt16LE(12+r+a+2),e.readUInt16LE(12+r+a+4),e.readUInt16LE(12+r+a+6),e.readUInt16LE(12+r+a+8),e.readUInt16LE(12+r+a+10),e.readUInt16LE(12+r+a+12),e.readUInt16LE(12+r+a+14)]);t[s]=I}break;case RRMapParser.TYPES.VIRTUAL_WALLS:const p=[];if(e.readUInt32LE(8+r)>0){for(let a=0;a<R;a+=8)p.push([e.readUInt16LE(12+r+a),e.readUInt16LE(12+r+a+2),e.readUInt16LE(12+r+a+4),e.readUInt16LE(12+r+a+6)]);t[s]=p}break;case RRMapParser.TYPES.CURRENTLY_CLEANED_BLOCKS:const T=[];if(e.readUInt32LE(8+r)>0){for(let a=0;a<R;a++)T.push(e.readUInt8(12+r+a));t[s]=T}break;case RRMapParser.TYPES.OBSTACLES_2:const L=e.readUInt32LE(8+r),P=[];if(L>0){const a=R/L;for(let t=0;t<L;t++){const E=12+r+t*a,s=e.readUInt16LE(E),n=e.readUInt16LE(E+2),R=e.readUInt16LE(E+4),o=e.readUInt16LE(E+6),i=e.readUInt16LE(E+8);let I=0,p=[];28==a?0==(255&e.readUInt8(12+r+t+12))||(p=e.readNbytes(E+12,16)):I=getUInt32LE(E+12),P.push([s,n,R,o,i,I,p])}t[s]=P}}return a(e,r+R+n,t)},RRMapParser.PARSE=function(a){if(114===a[0]&&114===a[1]){return{header_length:a.readUInt16LE(2),data_length:a.readUInt16LE(4),version:{major:a.readUInt16LE(8),minor:a.readUInt16LE(10)},map_index:a.readUInt16LE(12),map_sequence:a.readUInt16LE(16)}}return{}},RRMapParser.PARSEDATA=function(a){if(!this.PARSE(a).map_index)return null;const e=RRMapParser.PARSEBLOCK(a,20),r={};return e[RRMapParser.TYPES.IMAGE]&&(r.image=e[RRMapParser.TYPES.IMAGE],[{type:RRMapParser.TYPES.PATH,path:"path"},{type:RRMapParser.TYPES.GOTO_PREDICTED_PATH,path:"goto_predicted_path"}].forEach(a=>{e[a.type]&&(r[a.path]=e[a.type],r[a.path].points=r[a.path].points.map(a=>(a[1]=XiaomiRRTools.DIMENSION_MM-a[1],a)),r[a.path].points.length>=2&&(r[a.path].current_angle=180*Math.atan2(r[a.path].points[r[a.path].points.length-1][1]-r[a.path].points[r[a.path].points.length-2][1],r[a.path].points[r[a.path].points.length-1][0]-r[a.path].points[r[a.path].points.length-2][0])/Math.PI))}),e[RRMapParser.TYPES.CHARGER_LOCATION]&&(r.charger=e[RRMapParser.TYPES.CHARGER_LOCATION].position,r.charger[1]=XiaomiRRTools.DIMENSION_MM-r.charger[1]),e[RRMapParser.TYPES.ROBOT_POSITION]&&(r.robot=e[RRMapParser.TYPES.ROBOT_POSITION].position,r.robot[1]=XiaomiRRTools.DIMENSION_MM-r.robot[1]),e[RRMapParser.TYPES.GOTO_TARGET]&&(r.goto_target=e[RRMapParser.TYPES.GOTO_TARGET].position,r.goto_target[1]=XiaomiRRTools.DIMENSION_MM-r.goto_target[1]),e[RRMapParser.TYPES.CURRENTLY_CLEANED_ZONES]&&(r.currently_cleaned_zones=e[RRMapParser.TYPES.CURRENTLY_CLEANED_ZONES],r.currently_cleaned_zones=r.currently_cleaned_zones.map(a=>(a[1]=XiaomiRRTools.DIMENSION_MM-a[1],a[3]=XiaomiRRTools.DIMENSION_MM-a[3],a))),e[RRMapParser.TYPES.FORBIDDEN_ZONES]&&(r.forbidden_zones=e[RRMapParser.TYPES.FORBIDDEN_ZONES],r.forbidden_zones=r.forbidden_zones.map(a=>(a[1]=XiaomiRRTools.DIMENSION_MM-a[1],a[3]=XiaomiRRTools.DIMENSION_MM-a[3],a[5]=XiaomiRRTools.DIMENSION_MM-a[5],a[7]=XiaomiRRTools.DIMENSION_MM-a[7],a))),e[RRMapParser.TYPES.VIRTUAL_WALLS]&&(r.virtual_walls=e[RRMapParser.TYPES.VIRTUAL_WALLS],r.virtual_walls=r.virtual_walls.map(a=>(a[1]=XiaomiRRTools.DIMENSION_MM-a[1],a[3]=XiaomiRRTools.DIMENSION_MM-a[3],a))),e[RRMapParser.TYPES.CURRENTLY_CLEANED_BLOCKS]&&(r.currently_cleaned_blocks=e[RRMapParser.TYPES.CURRENTLY_CLEANED_BLOCKS]),e[RRMapParser.TYPES.OBSTACLES_2]&&(r.obstacles2=e[RRMapParser.TYPES.OBSTACLES_2],r.obstacles2=r.obstacles2.map(a=>(a[1]=XiaomiRRTools.DIMENSION_MM-a[1],a)))),r};

        /** @license zlib.js 2012 - imaya [ https://github.com/imaya/zlib.js ] The MIT License */(function() {'use strict';function n(e){throw e;}var p=void 0,aa=this;function t(e,b){var d=e.split("."),c=aa;!(d[0]in c)&&c.execScript&&c.execScript("var "+d[0]);for(var a;d.length&&(a=d.shift());)!d.length&&b!==p?c[a]=b:c=c[a]?c[a]:c[a]={}};var x="undefined"!==typeof Uint8Array&&"undefined"!==typeof Uint16Array&&"undefined"!==typeof Uint32Array&&"undefined"!==typeof DataView;new (x?Uint8Array:Array)(256);var y;for(y=0;256>y;++y)for(var A=y,ba=7,A=A>>>1;A;A>>>=1)--ba;function B(e,b,d){var c,a="number"===typeof b?b:b=0,f="number"===typeof d?d:e.length;c=-1;for(a=f&7;a--;++b)c=c>>>8^C[(c^e[b])&255];for(a=f>>3;a--;b+=8)c=c>>>8^C[(c^e[b])&255],c=c>>>8^C[(c^e[b+1])&255],c=c>>>8^C[(c^e[b+2])&255],c=c>>>8^C[(c^e[b+3])&255],c=c>>>8^C[(c^e[b+4])&255],c=c>>>8^C[(c^e[b+5])&255],c=c>>>8^C[(c^e[b+6])&255],c=c>>>8^C[(c^e[b+7])&255];return(c^4294967295)>>>0}
var D=[0,1996959894,3993919788,2567524794,124634137,1886057615,3915621685,2657392035,249268274,2044508324,3772115230,2547177864,162941995,2125561021,3887607047,2428444049,498536548,1789927666,4089016648,2227061214,450548861,1843258603,4107580753,2211677639,325883990,1684777152,4251122042,2321926636,335633487,1661365465,4195302755,2366115317,997073096,1281953886,3579855332,2724688242,1006888145,1258607687,3524101629,2768942443,901097722,1119000684,3686517206,2898065728,853044451,1172266101,3705015759,
2882616665,651767980,1373503546,3369554304,3218104598,565507253,1454621731,3485111705,3099436303,671266974,1594198024,3322730930,2970347812,795835527,1483230225,3244367275,3060149565,1994146192,31158534,2563907772,4023717930,1907459465,112637215,2680153253,3904427059,2013776290,251722036,2517215374,3775830040,2137656763,141376813,2439277719,3865271297,1802195444,476864866,2238001368,4066508878,1812370925,453092731,2181625025,4111451223,1706088902,314042704,2344532202,4240017532,1658658271,366619977,
2362670323,4224994405,1303535960,984961486,2747007092,3569037538,1256170817,1037604311,2765210733,3554079995,1131014506,879679996,2909243462,3663771856,1141124467,855842277,2852801631,3708648649,1342533948,654459306,3188396048,3373015174,1466479909,544179635,3110523913,3462522015,1591671054,702138776,2966460450,3352799412,1504918807,783551873,3082640443,3233442989,3988292384,2596254646,62317068,1957810842,3939845945,2647816111,81470997,1943803523,3814918930,2489596804,225274430,2053790376,3826175755,
2466906013,167816743,2097651377,4027552580,2265490386,503444072,1762050814,4150417245,2154129355,426522225,1852507879,4275313526,2312317920,282753626,1742555852,4189708143,2394877945,397917763,1622183637,3604390888,2714866558,953729732,1340076626,3518719985,2797360999,1068828381,1219638859,3624741850,2936675148,906185462,1090812512,3747672003,2825379669,829329135,1181335161,3412177804,3160834842,628085408,1382605366,3423369109,3138078467,570562233,1426400815,3317316542,2998733608,733239954,1555261956,
3268935591,3050360625,752459403,1541320221,2607071920,3965973030,1969922972,40735498,2617837225,3943577151,1913087877,83908371,2512341634,3803740692,2075208622,213261112,2463272603,3855990285,2094854071,198958881,2262029012,4057260610,1759359992,534414190,2176718541,4139329115,1873836001,414664567,2282248934,4279200368,1711684554,285281116,2405801727,4167216745,1634467795,376229701,2685067896,3608007406,1308918612,956543938,2808555105,3495958263,1231636301,1047427035,2932959818,3654703836,1088359270,
936918E3,2847714899,3736837829,1202900863,817233897,3183342108,3401237130,1404277552,615818150,3134207493,3453421203,1423857449,601450431,3009837614,3294710456,1567103746,711928724,3020668471,3272380065,1510334235,755167117],C=x?new Uint32Array(D):D;function E(){}E.prototype.getName=function(){return this.name};E.prototype.getData=function(){return this.data};E.prototype.G=function(){return this.H};function G(e){var b=e.length,d=0,c=Number.POSITIVE_INFINITY,a,f,k,l,m,r,q,g,h,v;for(g=0;g<b;++g)e[g]>d&&(d=e[g]),e[g]<c&&(c=e[g]);a=1<<d;f=new (x?Uint32Array:Array)(a);k=1;l=0;for(m=2;k<=d;){for(g=0;g<b;++g)if(e[g]===k){r=0;q=l;for(h=0;h<k;++h)r=r<<1|q&1,q>>=1;v=k<<16|g;for(h=r;h<a;h+=m)f[h]=v;++l}++k;l<<=1;m<<=1}return[f,d,c]};var J=[],K;for(K=0;288>K;K++)switch(!0){case 143>=K:J.push([K+48,8]);break;case 255>=K:J.push([K-144+400,9]);break;case 279>=K:J.push([K-256+0,7]);break;case 287>=K:J.push([K-280+192,8]);break;default:n("invalid literal: "+K)}
var ca=function(){function e(a){switch(!0){case 3===a:return[257,a-3,0];case 4===a:return[258,a-4,0];case 5===a:return[259,a-5,0];case 6===a:return[260,a-6,0];case 7===a:return[261,a-7,0];case 8===a:return[262,a-8,0];case 9===a:return[263,a-9,0];case 10===a:return[264,a-10,0];case 12>=a:return[265,a-11,1];case 14>=a:return[266,a-13,1];case 16>=a:return[267,a-15,1];case 18>=a:return[268,a-17,1];case 22>=a:return[269,a-19,2];case 26>=a:return[270,a-23,2];case 30>=a:return[271,a-27,2];case 34>=a:return[272,
a-31,2];case 42>=a:return[273,a-35,3];case 50>=a:return[274,a-43,3];case 58>=a:return[275,a-51,3];case 66>=a:return[276,a-59,3];case 82>=a:return[277,a-67,4];case 98>=a:return[278,a-83,4];case 114>=a:return[279,a-99,4];case 130>=a:return[280,a-115,4];case 162>=a:return[281,a-131,5];case 194>=a:return[282,a-163,5];case 226>=a:return[283,a-195,5];case 257>=a:return[284,a-227,5];case 258===a:return[285,a-258,0];default:n("invalid length: "+a)}}var b=[],d,c;for(d=3;258>=d;d++)c=e(d),b[d]=c[2]<<24|c[1]<<
16|c[0];return b}();x&&new Uint32Array(ca);function L(e,b){this.i=[];this.j=32768;this.d=this.f=this.c=this.n=0;this.input=x?new Uint8Array(e):e;this.o=!1;this.k=M;this.w=!1;if(b||!(b={}))b.index&&(this.c=b.index),b.bufferSize&&(this.j=b.bufferSize),b.bufferType&&(this.k=b.bufferType),b.resize&&(this.w=b.resize);switch(this.k){case N:this.a=32768;this.b=new (x?Uint8Array:Array)(32768+this.j+258);break;case M:this.a=0;this.b=new (x?Uint8Array:Array)(this.j);this.e=this.D;this.q=this.A;this.l=this.C;break;default:n(Error("invalid inflate mode"))}}
var N=0,M=1;
L.prototype.g=function(){for(;!this.o;){var e=P(this,3);e&1&&(this.o=!0);e>>>=1;switch(e){case 0:var b=this.input,d=this.c,c=this.b,a=this.a,f=b.length,k=p,l=p,m=c.length,r=p;this.d=this.f=0;d+1>=f&&n(Error("invalid uncompressed block header: LEN"));k=b[d++]|b[d++]<<8;d+1>=f&&n(Error("invalid uncompressed block header: NLEN"));l=b[d++]|b[d++]<<8;k===~l&&n(Error("invalid uncompressed block header: length verify"));d+k>b.length&&n(Error("input buffer is broken"));switch(this.k){case N:for(;a+k>c.length;){r=
m-a;k-=r;if(x)c.set(b.subarray(d,d+r),a),a+=r,d+=r;else for(;r--;)c[a++]=b[d++];this.a=a;c=this.e();a=this.a}break;case M:for(;a+k>c.length;)c=this.e({t:2});break;default:n(Error("invalid inflate mode"))}if(x)c.set(b.subarray(d,d+k),a),a+=k,d+=k;else for(;k--;)c[a++]=b[d++];this.c=d;this.a=a;this.b=c;break;case 1:this.l(da,ea);break;case 2:for(var q=P(this,5)+257,g=P(this,5)+1,h=P(this,4)+4,v=new (x?Uint8Array:Array)(Q.length),s=p,F=p,H=p,w=p,z=p,O=p,I=p,u=p,Z=p,u=0;u<h;++u)v[Q[u]]=P(this,3);if(!x){u=
h;for(h=v.length;u<h;++u)v[Q[u]]=0}s=G(v);w=new (x?Uint8Array:Array)(q+g);u=0;for(Z=q+g;u<Z;)switch(z=R(this,s),z){case 16:for(I=3+P(this,2);I--;)w[u++]=O;break;case 17:for(I=3+P(this,3);I--;)w[u++]=0;O=0;break;case 18:for(I=11+P(this,7);I--;)w[u++]=0;O=0;break;default:O=w[u++]=z}F=x?G(w.subarray(0,q)):G(w.slice(0,q));H=x?G(w.subarray(q)):G(w.slice(q));this.l(F,H);break;default:n(Error("unknown BTYPE: "+e))}}return this.q()};
var S=[16,17,18,0,8,7,9,6,10,5,11,4,12,3,13,2,14,1,15],Q=x?new Uint16Array(S):S,fa=[3,4,5,6,7,8,9,10,11,13,15,17,19,23,27,31,35,43,51,59,67,83,99,115,131,163,195,227,258,258,258],ga=x?new Uint16Array(fa):fa,ha=[0,0,0,0,0,0,0,0,1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,0,0,0],T=x?new Uint8Array(ha):ha,ia=[1,2,3,4,5,7,9,13,17,25,33,49,65,97,129,193,257,385,513,769,1025,1537,2049,3073,4097,6145,8193,12289,16385,24577],ja=x?new Uint16Array(ia):ia,ka=[0,0,0,0,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,
11,12,12,13,13],U=x?new Uint8Array(ka):ka,V=new (x?Uint8Array:Array)(288),W,la;W=0;for(la=V.length;W<la;++W)V[W]=143>=W?8:255>=W?9:279>=W?7:8;var da=G(V),X=new (x?Uint8Array:Array)(30),Y,ma;Y=0;for(ma=X.length;Y<ma;++Y)X[Y]=5;var ea=G(X);function P(e,b){for(var d=e.f,c=e.d,a=e.input,f=e.c,k=a.length,l;c<b;)f>=k&&n(Error("input buffer is broken")),d|=a[f++]<<c,c+=8;l=d&(1<<b)-1;e.f=d>>>b;e.d=c-b;e.c=f;return l}
function R(e,b){for(var d=e.f,c=e.d,a=e.input,f=e.c,k=a.length,l=b[0],m=b[1],r,q;c<m&&!(f>=k);)d|=a[f++]<<c,c+=8;r=l[d&(1<<m)-1];q=r>>>16;q>c&&n(Error("invalid code length: "+q));e.f=d>>q;e.d=c-q;e.c=f;return r&65535}
L.prototype.l=function(e,b){var d=this.b,c=this.a;this.r=e;for(var a=d.length-258,f,k,l,m;256!==(f=R(this,e));)if(256>f)c>=a&&(this.a=c,d=this.e(),c=this.a),d[c++]=f;else{k=f-257;m=ga[k];0<T[k]&&(m+=P(this,T[k]));f=R(this,b);l=ja[f];0<U[f]&&(l+=P(this,U[f]));c>=a&&(this.a=c,d=this.e(),c=this.a);for(;m--;)d[c]=d[c++-l]}for(;8<=this.d;)this.d-=8,this.c--;this.a=c};
L.prototype.C=function(e,b){var d=this.b,c=this.a;this.r=e;for(var a=d.length,f,k,l,m;256!==(f=R(this,e));)if(256>f)c>=a&&(d=this.e(),a=d.length),d[c++]=f;else{k=f-257;m=ga[k];0<T[k]&&(m+=P(this,T[k]));f=R(this,b);l=ja[f];0<U[f]&&(l+=P(this,U[f]));c+m>a&&(d=this.e(),a=d.length);for(;m--;)d[c]=d[c++-l]}for(;8<=this.d;)this.d-=8,this.c--;this.a=c};
L.prototype.e=function(){var e=new (x?Uint8Array:Array)(this.a-32768),b=this.a-32768,d,c,a=this.b;if(x)e.set(a.subarray(32768,e.length));else{d=0;for(c=e.length;d<c;++d)e[d]=a[d+32768]}this.i.push(e);this.n+=e.length;if(x)a.set(a.subarray(b,b+32768));else for(d=0;32768>d;++d)a[d]=a[b+d];this.a=32768;return a};
L.prototype.D=function(e){var b,d=this.input.length/this.c+1|0,c,a,f,k=this.input,l=this.b;e&&("number"===typeof e.t&&(d=e.t),"number"===typeof e.z&&(d+=e.z));2>d?(c=(k.length-this.c)/this.r[2],f=258*(c/2)|0,a=f<l.length?l.length+f:l.length<<1):a=l.length*d;x?(b=new Uint8Array(a),b.set(l)):b=l;return this.b=b};
L.prototype.q=function(){var e=0,b=this.b,d=this.i,c,a=new (x?Uint8Array:Array)(this.n+(this.a-32768)),f,k,l,m;if(0===d.length)return x?this.b.subarray(32768,this.a):this.b.slice(32768,this.a);f=0;for(k=d.length;f<k;++f){c=d[f];l=0;for(m=c.length;l<m;++l)a[e++]=c[l]}f=32768;for(k=this.a;f<k;++f)a[e++]=b[f];this.i=[];return this.buffer=a};
L.prototype.A=function(){var e,b=this.a;x?this.w?(e=new Uint8Array(b),e.set(this.b.subarray(0,b))):e=this.b.subarray(0,b):(this.b.length>b&&(this.b.length=b),e=this.b);return this.buffer=e};function $(e){this.input=e;this.c=0;this.m=[];this.s=!1}$.prototype.F=function(){this.s||this.g();return this.m.slice()};
$.prototype.g=function(){for(var e=this.input.length;this.c<e;){var b=new E,d=p,c=p,a=p,f=p,k=p,l=p,m=p,r=p,q=p,g=this.input,h=this.c;b.u=g[h++];b.v=g[h++];(31!==b.u||139!==b.v)&&n(Error("invalid file signature:"+b.u+","+b.v));b.p=g[h++];switch(b.p){case 8:break;default:n(Error("unknown compression method: "+b.p))}b.h=g[h++];r=g[h++]|g[h++]<<8|g[h++]<<16|g[h++]<<24;b.H=new Date(1E3*r);b.N=g[h++];b.M=g[h++];0<(b.h&4)&&(b.I=g[h++]|g[h++]<<8,h+=b.I);if(0<(b.h&8)){m=[];for(l=0;0<(k=g[h++]);)m[l++]=String.fromCharCode(k);
b.name=m.join("")}if(0<(b.h&16)){m=[];for(l=0;0<(k=g[h++]);)m[l++]=String.fromCharCode(k);b.J=m.join("")}0<(b.h&2)&&(b.B=B(g,0,h)&65535,b.B!==(g[h++]|g[h++]<<8)&&n(Error("invalid header crc16")));d=g[g.length-4]|g[g.length-3]<<8|g[g.length-2]<<16|g[g.length-1]<<24;g.length-h-4-4<512*d&&(f=d);c=new L(g,{index:h,bufferSize:f});b.data=a=c.g();h=c.c;b.K=q=(g[h++]|g[h++]<<8|g[h++]<<16|g[h++]<<24)>>>0;B(a,p,p)!==q&&n(Error("invalid CRC-32 checksum: 0x"+B(a,p,p).toString(16)+" / 0x"+q.toString(16)));b.L=
d=(g[h++]|g[h++]<<8|g[h++]<<16|g[h++]<<24)>>>0;(a.length&4294967295)!==d&&n(Error("invalid input size: "+(a.length&4294967295)+" / "+d));this.m.push(b);this.c=h}this.s=!0;var v=this.m,s,F,H=0,w=0,z;s=0;for(F=v.length;s<F;++s)w+=v[s].data.length;if(x){z=new Uint8Array(w);for(s=0;s<F;++s)z.set(v[s].data,H),H+=v[s].data.length}else{z=[];for(s=0;s<F;++s)z[s]=v[s].data;z=Array.prototype.concat.apply([],z)}return z};t("Zlib.Gunzip",$);t("Zlib.Gunzip.prototype.decompress",$.prototype.g);t("Zlib.Gunzip.prototype.getMembers",$.prototype.F);t("Zlib.GunzipMember",E);t("Zlib.GunzipMember.prototype.getName",E.prototype.getName);t("Zlib.GunzipMember.prototype.getData",E.prototype.getData);t("Zlib.GunzipMember.prototype.getMtime",E.prototype.G);}).call(this);
        
        var floor;
        var obstacle;
        var path;
        var imgRobot;
        var imgCharger;
        var imgObstacle;
        var segmentColors = [];
        var selectedSegments;
        var myAvailableSegments = [];
        var mapParsed;
        var robotIsCleaning;

        this.addToAvailableSegments = function (segment, color) {
            this.myAvailableSegments[color] = segment;
        }

        this.loadBufferFromBase64 = function (base64) {
            const raw = window.atob( base64 );
            let myArray = [];
            
            for(i=0;i<raw.length;i++ )
                myArray[i] = raw.charCodeAt(i);

            this.loadBuffer (Uint8Array.from (myArray));
        }
            
        this.loadBuffer = function (data) {
            const buffer = new Uint8Array(data);

            let plain = null;
            if (buffer[0x00] === 0x1f && buffer[0x01] === 0x8b) { // gzipped data
                var gunzip = new this.Zlib.Gunzip(buffer);
                plain = new XiaomiVSEBuffer (gunzip.decompress());
            } else if (buffer[0x00] === 0x72 && buffer[0x01] === 0x72) {
                // Unkomprimierte Daten
                plain = new XiaomiVSEBuffer (buffer);
            }
            
            if (plain != null) {
                this.mapParsed = RRMapParser.PARSEDATA(plain);
                this.myAvailableSegments = [];
            }
        }

        this.getSegmentColor = function (segnum) {
            const myColor = this.segmentColors[segnum % (this.segmentColors.length-1)];
            this.addToAvailableSegments (segnum, myColor);
            return (myColor);
        }
            
        this.init = function (imgRobot, imgCharger, imgObstacle, segmentColors) {
	    this.imgRobot = imgRobot;
	    this.imgCharger = imgCharger;
	    this.imgObstacle = imgObstacle;
	    this.segmentColors = segmentColors;
	    this.selectedSegments = [];
	    this.floor = '#dfdfdf';
	    this.obstacle = '#5e777c';
	    this.path = '#ffffff';
	    this.mapParsed = null;
	    this.robotIsCleaning = false;
	    this.repeatCleaning = 1;
            //console.log ("segmentColorsInit: "+ this.segmentColors+ "len = "+this.segmentColors.length + "segColors: "+ segmentColors.length);
        }
        
    }
    
    visuElement_newGlobal(elementId,{XiaomiView:new class_XiaomiView()});

    var veVar=visuElement_getGlobal(elementId);

    veVar.XiaomiView.init (imgRobot, imgCharger, imgObstacle, myMapColors[obj.dataset.var2]);

    if (visuElement_hasKo(elementId,2)) {
        // nur short-click
        visuElement_onClick(obj,
                            function(veId,objId){VSE_VSEID_clickControl(veId,false);},false);
    };
}

VSE_VSEID_REFRESH=function(elementId,obj,isInit,isRefresh,isLive,isActive,koValue) {
    if (visuElement_hasKo(elementId,1)) {
        var veVar=visuElement_getGlobal(elementId);
        
        var url = visuElement_getKoValue(elementId, 1).split("!!:");

        if (url[1] !== undefined) {
            switch (url[1]) {
            case 'isCleaning':
                veVar.robotIsCleaning = true;
                break;
            default:
                veVar.robotIsCleaning = false;
                break;
            }
        } else {
            veVar.robotIsCleaning = false;
        }

        if (veVar.robotIsCleaning && obj.dataset.var4 > 0) {
            visuElement_setTimeout (elementId, 2, obj.dataset.var4, function(id) {
                visuElement_setKoValue(elementId, 2, "!!:refreshMap");
            });
        } else {
            visuElement_clearTimeout(elementId,1);
        }

        visuElement_callPhp("loadImg",{elementId:elementId,url:url[0]},null);
    }
};

VSE_VSEID_clickControl=function(elementId,long) {
    var obj=document.getElementById("e-"+elementId);
    var veVar=visuElement_getGlobal(elementId);
    
    if (obj && veVar) {
        //Kurz-Klick
        const canvas_final = document.getElementById("canvasFinal"+elementId);
        const ctx_final = canvas_final.getContext('2d');

        const mousePos=visuElement_getMousePosition(obj,canvas_final,0);

        function getPixel (x,y) {
            const pixel = ctx_final.getImageData(x, y, 1, 1).data;
            const color = "#"+RGBtoRGBHEX (pixel[0],pixel[1],pixel[2]);
            return ([pixel, color]);
        }

        function markArea(color, data, select) {
            var newColor = '';
            
            for (var i = 0; i < data.length; i+=4) {
                if ( (color[0] == data[i]) &&
                     (color[1] == data[i+1]) &&
                     (color[2] == data[i+2])
                ) {
                    
                    if (select) {
                        data[i] /=2;
                        data[i+1] /=2;
                        data[i+2] /=2;
                    } else {
                        data[i] *=2;
                        data[i+1] *=2;
                        data[i+2] *=2;
                    }
                    if (newColor == '') {
                        newColor = "#"+RGBtoRGBHEX (data[i],data[i+1],data[i+2]);
                    }
                }
            }
            return (newColor);
        }

        function checkIfColorExists (x,y) {
            let [pixel,color] = getPixel (x, y);
            for (var key in veVar.XiaomiView.myAvailableSegments) {
                //console.log ("key = "+key+" color ="+color);
                if (key == color) {
                    return ([key,pixel]);
                }
            }
            return ([null,null]);
        }

        let [key, pixel] = checkIfColorExists (mousePos.x, mousePos.y);
        
        if (key == null) {
            // Falls der Klick auf dem Reiniungspfad erfolgt ist, nochmal einen Versuch unternehmen
            for (i=0;i<5;i++) {
                [key,pixel] = checkIfColorExists (mousePos.x+2*i, mousePos.y+2*i);
                if (key != null)
                    break;
            }
        }

        if (key != null) {
            let imageData = ctx_final.getImageData(0, 0, canvas_final.width, canvas_final.height);
            let mode;
            let index = veVar.XiaomiView.selectedSegments.indexOf(veVar.XiaomiView.myAvailableSegments[key]);

            if (index !== -1) {
                mode = 0;
                veVar.XiaomiView.selectedSegments.splice(index, 1);
            } else {
                mode = 1;
                veVar.XiaomiView.selectedSegments.push(veVar.XiaomiView.myAvailableSegments[key]);
            }
            let newCol = markArea (pixel, imageData.data, mode);
            
            veVar.XiaomiView.addToAvailableSegments (veVar.XiaomiView.myAvailableSegments[key], newCol);
            
            if (veVar.XiaomiView.selectedSegments.length == 0) {
                visuElement_clearTimeout(elementId,1);
            } else {
                visuElement_setTimeout (elementId, 1, obj.dataset.var3, function(id) {
                    visuElement_setKoValue(elementId, 2, veVar.XiaomiView.selectedSegments.toString()+";"+veVar.XiaomiView.repeatCleaning);
                    veVar.XiaomiView.selectedSegments = [];
                });
            }
            ctx_final.putImageData(imageData, 0, 0);
        }
    }
}


VSE_VSEID_loadMap = function (elementId,theUrl) {
    if (theUrl && theUrl.trim().length) {
        
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.responseType = "arraybuffer";
        
        xmlHttp.onreadystatechange = function() {
            //console.log ("readystate:"+xmlHttp.readyState+" http-state:"+xmlHttp.status);
            
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                
                var veVar=visuElement_getGlobal(elementId);
                veVar.XiaomiView.loadBuffer (xmlHttp.response);
                
                VSE_VSEID_CanvasMap (elementId);
                //VSE_VSEID_renderMap (elementId, xmlHttp.response);
            }
        }
        xmlHttp.open("GET", theUrl, true); // true for asynchronous 
        xmlHttp.send(null);
    } else {
        //console.log ("empty url!");
    }
}

VSE_VSEID_CanvasMap = function (elementId) {
    var veVar=visuElement_getGlobal(elementId);

    const Mapdata = veVar.XiaomiView.mapParsed;

    if (Mapdata == null) {
        return;
    }
    var canvasimg = document.createElement('canvas');

    let colors = {
        floor: '#dfdfdf',
        obstacle: '#5e777c',
        path: '#ffffff',
    };

    colors.floor = veVar.XiaomiView.floor;
    colors.obstacle = veVar.XiaomiView.obstacle;
    colors.path = veVar.XiaomiView.path;

    var canvas = document.createElement('canvas'); //*/ adapter.getElementById ("canvasTmp");
    canvas.height = 1024 * 4; //Mapdata.image.dimensions.height;
    canvas.width = 1024 * 4; //Mapdata.image.dimensions.width;

    var ctx = canvas.getContext('2d');

    var minX = 1024*4;
    var minY = 1024*4;
    var maxX = 0;
    var maxY = 0;

    function findMxy (_x, _y) {
        if (minX > _x) minX = _x;
        if (minY > _y) minY = _y;
	
        if (maxX < (_x+4)) maxX = _x+4;
        if (maxY < (_y+4)) maxY = _y+4;
    }

        if (Mapdata.image.pixels.floor && Mapdata.image.pixels.floor.length !== 0) {
            if (typeof (Mapdata.image.pixels.floor[0]) === 'object') { //alte Valetudo version und Re bis 0.8
            
                // Male Boden
                if (Mapdata.image.pixels.floor && Mapdata.image.pixels.floor.length !== 0) {
                    ctx.fillStyle = colors.floor;
                    Mapdata.image.pixels.floor.forEach(function (coord) {
                        var paintX = (coord[0] + Mapdata.image.position.left) * 4;
                        var paintY = (coord[1] + Mapdata.image.position.top) * 4;
                        findMxy (paintX, paintY);
                        ctx.fillRect(paintX, paintY, 4, 4);
                    });
                }
                // Male Wände
                if (Mapdata.image.pixels.obstacle_strong && Mapdata.image.pixels.obstacle_strong.length !== 0) {
                    ctx.fillStyle = colors.obstacle;
                    Mapdata.image.pixels.obstacle_strong.forEach(function (coord) {
                        var paintX = (coord[0] + Mapdata.image.position.left) * 4;
                        var paintY = (coord[1] + Mapdata.image.position.top) * 4;
                        findMxy (paintX, paintY);
                        ctx.fillRect(paintX, paintY, 4, 4);
                    });
                }
            } else if (typeof (Mapdata.image.pixels.floor[0]) === 'number') { // neuere ValetudoRE und stock
                ['floor', 'obstacle'].forEach(key => {
                        ctx.fillStyle = (key == 'obstacle') ? colors.obstacle : colors.floor;

                        Mapdata.image.pixels[key].forEach(function drawPixel(px) {
                            var paintX = ((px % Mapdata.image.dimensions.width) + Mapdata.image.position.left) * 4;
                            var paintY = (Mapdata.image.dimensions.height - 1 - (Math.floor(px / Mapdata.image.dimensions.width)) + Mapdata.image.position.top )*4;
                            findMxy (paintX, paintY);
                            ctx.fillRect(paintX, paintY, 4, 4);
		    
                            //console.log ("px = "+px);
                        });
                    });
            }
        }

    // Zeichne Alle Räume
    if (Mapdata.image.pixels.segments) {
        let i, j, segnum;
        Mapdata.image.pixels.segments.forEach(px => {
                segnum = (px >> 21);
                ctx.fillStyle = veVar.XiaomiView.getSegmentColor (segnum);
                px = px & 0xfffff;
                ctx.fillRect((px % Mapdata.image.dimensions.width) * 4 + Mapdata.image.position.left * 4, (Mapdata.image.dimensions.height - 1 - Math.floor(px / Mapdata.image.dimensions.width)) * 4 + Mapdata.image.position.top * 4, 4, 4);
            });
    }

    // Sperrzonen
    if (Mapdata.forbidden_zones) {
        if (typeof Mapdata.forbidden_zones[0] !== 'undefined') {
            ctx.beginPath();
            Mapdata.forbidden_zones.forEach(function (coord) {
                ctx.fillStyle = 'rgba(255,0,0,0.3)';
                
                ctx.moveTo(coord[0] / 12.5, coord[1] / 12.5);
                ctx.lineTo(coord[2] / 12.5, coord[3] / 12.5);
                ctx.lineTo(coord[4] / 12.5, coord[5] / 12.5);
                ctx.lineTo(coord[6] / 12.5, coord[7] / 12.5);
                ctx.lineTo(coord[0] / 12.5, coord[1] / 12.5);
                ctx.closePath();
                ctx.fill();
            });
        }
    }
    // Virtuelle Wände
    if (Mapdata.virtual_walls) {
        if (typeof Mapdata.virtual_walls[0] !== 'undefined') {
            ctx.beginPath();
            Mapdata.virtual_walls.forEach(function (coord) {
                ctx.strokeStyle = 'rgba(255,0,0,0.3)';
		
                ctx.moveTo(coord[0] / 12.5, coord[1] / 12.5);
                ctx.lineTo(coord[2] / 12.5, coord[3] / 12.5);
                ctx.lineWidth=4;
                ctx.stroke();
            });
        }
    }

    // Zeichne Zonen
    if (Mapdata.currently_cleaned_zones) {
        if (typeof Mapdata.currently_cleaned_zones[0] !== 'undefined') {
            ctx.beginPath();
            Mapdata.currently_cleaned_zones.forEach(function (coord) {
                const p1 = coord[0] / 12.5;
                const p2 = coord[1] / 12.5;
                const p3 = (coord[2]-coord[0]) / 12.5;
                const p4 = (coord[3]-coord[1]) / 12.5;
                ctx.fillStyle = 'rgba(46,139,87,0.1)';
                ctx.fillRect(p1, p2, p3, p4);
                ctx.strokeStyle = '#2e8b57';
                ctx.lineWidth = 4;
                ctx.strokeRect(p1,p2,p3,p4);
            });
        }
    }

    // Male den Pfad
    if (typeof (Mapdata.path) !== 'undefined') {
        if (Mapdata.path.points && Mapdata.path.points.length !== 0) {
            ctx.fillStyle = colors.path;
            let first = true;
            let cold1, cold2;
            
            Mapdata.path.points.forEach(function (coord) {
                if (first) {
                    ctx.fillRect(coord[0] / 12.5, coord[1] / 50, 2, 2);
                    cold1 = coord[0] / 12.5;
                    cold2 = coord[1] / 12.5;
                } else {
                    ctx.beginPath();
                    ctx.lineWidth = 1;
                    ctx.strokeStyle = colors.path;
                    ctx.moveTo(cold1, cold2);
                    ctx.lineTo(coord[0] / 12.5, coord[1] / 12.5);
                    ctx.stroke();
                    
                    cold1 = coord[0] / 12.5;
                    cold2 = coord[1] / 12.5;
                }
                first = false;
            });
        }
    }

    // Zeichne Ladestation
    if (Mapdata.charger) {
        if (typeof Mapdata.charger[0] !== 'undefined' && typeof Mapdata.charger[1] !== 'undefined') {
            ctx.drawImage(veVar.XiaomiView.imgCharger, Mapdata.charger[0] / 12.5 - 15, Mapdata.charger[1] / 12.5 - 15);
        }
    }

    // Zeichne Roboter
    if (Mapdata.robot) {
        if (Mapdata.path.current_angle && typeof Mapdata.robot[0] !== 'undefined' && typeof Mapdata.robot[1] !== 'undefined') {
            canvasimg = VSE_VSEID_rotateCanvas(veVar.XiaomiView.imgRobot, Mapdata.path.current_angle);
            ctx.drawImage(canvasimg, Mapdata.robot[0] / 12.5 - 50, Mapdata.robot[1] / 12.5 - 50, 100, 100);
        } else {
            ctx.drawImage(veVar.XiaomiView.imgRobot, Mapdata.robot[0] / 12.5 - (veVar.XiaomiView.imgRobot.width / 2), Mapdata.robot[1] / 12.5 - (veVar.XiaomiView.imgRobot.height / 2), veVar.XiaomiView.imgRobot.width, veVar.XiaomiView.height);
        }
    }

    if (Mapdata.obstacles2) {
        if (typeof Mapdata.obstacles2[0] !== 'undefined') {
            Mapdata.obstacles2.forEach(function (coord) {
                ctx.drawImage(veVar.XiaomiView.imgObstacle, coord[0]/12.5-25,coord[1]/12.5-25);
            });
        }
    }

    // Crop, Scale, Rotate and center to visu-canvas
    
    let canvas_final = document.getElementById("canvasFinal"+elementId);
    let ctx_final = canvas_final.getContext('2d');

    var trimmed = ctx.getImageData(minX, minY, maxX-minX, maxY-minY);
    canvas.width = maxX-minX;
    canvas.height = maxY-minY;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.putImageData(trimmed,0,0);


    var rotated = 0;
    if (canvas.height > canvas.width) {
        if (canvas_final.width > canvas_final.height) {
            rotated = 1;
            ctx_final.translate(canvas_final.width / 2, canvas_final.height / 2);
            ctx_final.rotate (90*Math.PI / 180);
            ctx_final.translate(-canvas_final.height / 2, -canvas_final.width / 2);
        }
    }
    
    ctx_final.clearRect(0, 0, canvas_final.width, canvas_final.height);
    
    var aspectRatio = VSE_VSEID_calculateAspectRatioRotationFit (canvas_final, canvas, rotated);
    ctx_final.drawImage(canvas,
			aspectRatio.x,
			aspectRatio.y,
			aspectRatio.width, aspectRatio.height);

    canvas.remove();
};

VSE_VSEID_calculateAspectRatioRotationFit = function (destination, source, rotated) {
    var ratio;

    var newWidth;
    var newHeight;
    var dx;
    var dy;
    
    if (!rotated) {
        ratio = Math.min(destination.width / source.width, destination.height / source.height);
        newWidth = source.width*ratio;
        newHeight = source.height*ratio;
        
        dx = Math.abs(newWidth - destination.width)/2;
        dy = Math.abs(newHeight - destination.height)/2;
    } else {
        ratio = Math.min(destination.width / source.height, destination.height / source.width);
        newWidth = source.width*ratio;
        newHeight = source.height*ratio;
        
        dx = Math.abs(newWidth - destination.height)/2;
        dy = Math.abs(newHeight - destination.width)/2;
    }

    //console.log ("dx: "+dx+" dy: "+dy+ "newW: "+newWidth+ " NewH: "+newHeight+ "origW: "+destination.width+" origH: "+destination.height+ " radio: "+ratio);
    
    return { x:dx , y:dy, width: newWidth , height: newHeight };
}

VSE_VSEID_rotateCanvas = function (img, angle) {
    var canvasimg = document.createElement('canvas');
    canvasimg.width=100;
    canvasimg.height=100;
    
    var ctximg = canvasimg.getContext('2d');
    const offset = 90;

    ctximg.clearRect(0, 0, 100, 100);
    ctximg.translate(100 / 2, 100 / 2);
    ctximg.rotate((angle + offset) * Math.PI / 180);
    ctximg.translate(-100 / 2, -100 / 2);
    ctximg.drawImage(img, (100 / 2) - (img.width / 2), (100 / 2) - (img.height / 2));
    return canvasimg;
};

  VSE_VSEID_RepeatClicked = function (elementId) {
      var veVar=visuElement_getGlobal(elementId);

      let rC = veVar.XiaomiView.repeatCleaning;
      if (++rC >3) rC = 1;

      veVar.XiaomiView.repeatCleaning = rC;
      
      document.getElementById("VSE_VSEID_repeat"+elementId).innerHTML = rC+"x";
      return;
  }
  
###[/VISU.JS]###

###[SHARED.JS]###
  VSE_VSEID_CreateElement=function(elementId,obj, buttonColor) {
     var mWidthReal = parseInt(obj.style.width);
     var mHeightReal = parseInt(obj.style.height);
     var centerButton = Math.trunc ((mWidthReal - 50)/2);
     
     var myStyle = "<style>.button {min-width: 50px;min-height: 50px;font-family: sans-serif;font-size: 22px;font-weight: 700;background:"+buttonColor+";border:none;border-radius:100px;box-shadow:12px 12px 24px rgba(79,209,197,.25);transition: all 0.3s ease-in-out 0s;cursor: pointer;outline: none;position: absolute;top:20px; left:"+centerButton+"px;padding: 10px;} \
 .button::before {content: '';border-radius: 1000px;min-width: calc(300px + 12px);min-height: calc(60px + 12px);border: 6px solid #FFFFCB;box-shadow: 0 0 60px rgba(0,25,203,.64);position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);opacity: 0;transition: all .3s ease-in-out 0s;} \
.button:hover, button:focus {transform: scale(1.2);} \
.button::after {content: '';width: 30px; height: 30px;border-radius: 100%;border: 2px solid #FF0000;position: absolute;z-index:-1;top:50%;left:50%;transform: translate(-50%, -50%);animation: ring 3s infinite;}  @keyframes ring {0% {width: 10px;  height: 10px;  opacity: 1;}  100% {width: 100px;  height: 100px;  opacity: 0;}</style>";

     var button = '<button class="button" id="VSE_VSEID_repeat'+elementId+'" onclick="VSE_VSEID_RepeatClicked ('+elementId+')">1x</button>';
     var n = '<canvas id="canvasFinal'+elementId+'" width="'+mWidthReal+'" height="'+mHeightReal+'"></canvas>';

     obj.innerHTML = myStyle;
     obj.innerHTML += n+button;
 }
###[/SHARED.JS]###

###[HELP]###
Das Visuelement "Xiaomi Reinigungskarte"
    
<h2>Spezifische Eigenschaften</h2>

KO1 sowie KO2 sind jeweils 2 Variablen (Datentyp Variant), die mit dem Baustein 19001929_lbs kommunizieren.

Über KO1 wird dem VSE ein URL zum laden der Map mitgeteilt.
Über KO2 wird dem LBS mitgeteilt, welche Zone gereinigt werden soll.

Nachdem der Roboter die Karte erstellt hat, werden verschiedene Zonen in der Karte angezeigt.
Beim klicken auf die entsprechende Farbzone wird eine entsprechende Raum/Zonenreinigung ausgelöst. Es können binnen der
eingestellten Verzögerungszeit mehere Zonen ausgewählt werden.

<h2>Einstellungen</h2>
<ul>
  <li>Roboter-Icon
    <ul>
      <li>Verschiedene Icons zur Visualisierung des Roboters in der Karte</li>
    </ul>
  </li>
  <li>Kartenfarben
    <ul>
      <li>Vordefinierte Farben für die Segmente in der Karte</li>
    </ul>
  </li>
</ul>
<h2>Klick-Zeit</h2>
<ul>
  <li>Verzögerung
    <ul>
         <li>Binnen der eingestellten Zeit können Zonen selektiert oder auch wieder deselektiert werden.
         Nach Ablauf dieser Zeit beginnt die Reinigung der ausgewählten Zonen.
         </li>
    </ul>
  </li>
</ul>
<h2>Kartenaktualisierung</h2>
<ul>
  <li>Intervall
    <ul>
         <li>Wenn der Roboter aktiv ist, wird die Karte entsprechend der eingestellten Zeit aktualisiert.</li>
         <li>hierfür wird der Baustein 19001929_lbs.php mit Software 0.92 (oder neuer) benötigt</li>
    </ul>
  </li>
</ul>
<h2>Kommunikationsobjekte</h2>
<ul>
  <li>
    KO1: Status
    <ul>
      <li>Map-URL aus <b>A40</b></li>
      <li>Sofern Valetudo auf dem Roboter installiert ist, muss hier <b>http://[IP DES ROBOTERS]/api/map/latest</b> verwendet werden.</li>
      <li><b>Keine Unterstützung für Viomi-Maps, es wird nur RRMap unterstützt!!</b></li>
    </ul>
  </li>
  <li>
    KO2: Wert setzen
    <ul>
      <li>zu reinigende Zone an <b>E20</b></li>
    </ul>
  </li>
</ul>

<h2>Rechtline Hinweise</h2>
Extern eingesetzte und veränderte JS-Libs:
<ul>
  <li>zlib.js 2012 - [ <a href="https://github.com/imaya/zlib.js">imaya</a> ]</li>
  <li>mapCreater.js + RRMapParser.js aus iobroker adaptiert, optimiert und erweitert</li>
</ul>

(w) by Nima Ghassemi Nejad &lt;ngn928@web.de&gt; - Version 0.58

###[/HELP]###
