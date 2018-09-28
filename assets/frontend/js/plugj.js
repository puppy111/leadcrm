! function(t) {
    t.fn.tab.Constructor.TRANSITION_DURATION = 190, t(".rbt_tab .nav > li > a").on("shown.bs.tab", function(a) {
        t("video").each(function() {
            this.pause()
        })
    }), t(".rbt_tab .nav > li > a").on("shown.bs.tab", function(a) {
        var n = t(a.relatedTarget.hash).find("iframe"),
            r = n.attr("src");
        n.attr("src", ""), n.attr("src", r)
    })
}(jQuery);